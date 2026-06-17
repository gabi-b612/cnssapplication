# Suivi des mises à jour — Application CNSS

> Document de pilotage pour implémenter les fonctionnalités **une par une**, sans tout faire en même temps.
>
> **Dernière mise à jour :** 17 juin 2026

---

## État actuel du projet (résumé)

| Élément | Existant aujourd'hui | Cible demandée |
|--------|----------------------|----------------|
| Statuts demande | `en_attente`, `validee`, `rejetee`, `liquidee` | Brouillon → Soumise → En vérification → Approuvée → Payée / Rejetée |
| Montants allocations | Taux % en config admin (non utilisés au calcul) | Montants fixes : maternité **72 000 FC**, familiale **24 300 FC**, prénatale **16 200 FC** |
| Déclaration employeur | 1 demande = 1 travailleur + 1 type | Plusieurs demandes possibles par travailleur |
| PDF | Liens `storage/...` (ouverture externe) | Lecteur PDF intégré dans l'app |
| Notifications | Aucune | Email  à la validation et à la liquidation |
| Page d'accueil | Redirection vers `/login` | Page d'accueil CNSS avec logo |
| Rapports | Dashboard basique (compteurs) | Rapports statistiques exportables |
| Facture | Non | PDF facture après liquidation |

---

## Ordre d'implémentation recommandé

L'ordre ci-dessous limite les retours en arrière : on pose d'abord les fondations (statuts, montants), puis l'UX, puis les automatisations.

| # | ID | Fonctionnalité | Priorité | Dépend de |
|---|----|----------------|----------|-----------|
| 1 | F01 | Refonte du cycle de vie des statuts | 🔴 Haute | — |
| 2 | F02 | Montants fixes & calcul des allocations | 🔴 Haute | F01 (partiel) |
| 3 | F03 | Conditions d'éligibilité par type d'allocation | 🟠 Moyenne | F02 |
| 4 | F04 | Déclaration multiple (employeur) | 🟠 Moyenne | F01, F03 |
| 5 | F05 | Consulter statut / détail dossier (employeur & travailleur) | 🔴 Haute | F01 |
| 6 | F06 | Réclamation travailleur | 🟡 Basse | F05 |
| 7 | F07 | Lecteur PDF intégré | 🔴 Haute | — |
| 8 | F08 | Logo CNSS & page d'accueil | 🟢 Facile | — |
| 9 | F09 | Notifications email (validation + liquidation) | 🔴 Haute | F01 |
| 10 | F10 | Notifications SMS (optionnel) | 🟡 Basse | F09 |
| 11 | F11 | Génération facture PDF (après liquidation) | 🟠 Moyenne | F02, F07 |
| 12 | F12 | Rapports statistiques | 🟠 Moyenne | F01 |

---

## Détail par fonctionnalité

### F01 — Cycle de vie des statuts

**Statut :** ⬜ À faire

**Objectif :** Aligner le modèle métier sur les 6 états visibles par tous les acteurs.

| Statut métier | Code technique proposé | Qui agit ? |
|---------------|------------------------|------------|
| Brouillon | `brouillon` | Employeur (sauvegarde sans soumettre) |
| Soumise | `soumise` | Employeur (envoi définitif) |
| En vérification | `en_verification` | Agent APF (prise en charge) |
| Approuvée | `approuvee` | Agent APF (validation) |
| Payée | `payee` | Admin (liquidation enregistrée) |
| Rejetée | `rejetee` | Agent APF |

**Fichiers impactés :**
- Migration `demandes.statut`
- Modèle `Demande`, contrôleurs Entreprise / APF / Admin
- Toutes les vues listant un statut (badges, filtres)

**Critères d'acceptation :**
- [ ] Migration des anciennes valeurs (`en_attente` → `en_verification`, `validee` → `approuvee`, `liquidee` → `payee`)
- [ ] Badges cohérents sur employeur, travailleur, APF, admin
- [ ] Historique ou date de changement de statut (recommandé)

---

### F02 — Montants fixes & calcul des allocations

**Statut :** ⬜ À faire

**Montants de référence :**

| Type | Montant (FC) |
|------|-------------|
| Allocation maternité | 72 000 |
| Allocation familiale | 24 300 |
| Allocation prénatale | 16 200 |

**Approche proposée :**
1. Stocker les montants en `configurations` (ou constantes + override admin).
2. Service `AllocationCalculator` : `montant = montant_base × (taux / 100)` si les taux admin restent utiles, **ou** montant fixe pur.
3. Pré-remplir le montant à la liquidation ; l'admin peut ajuster avec justification.

**Fichiers impactés :**
- `Configuration` + migration
- `Admin\ConfigurationController`, vue configuration
- `Admin\LiquidationController`, formulaire liquidation
- Nouveau : `App\Services\AllocationCalculator.php`

**Critères d'acceptation :**
- [ ] Montant affiché à la création / validation selon le type
- [ ] Montant proposé automatiquement lors de la liquidation
- [ ] Cohérence FC partout (éviter mélange `$` / `FC`)

---

### F03 — Conditions d'éligibilité

**Statut :** ⬜ À faire — **règles métier à valider avec vous**

**Conditions proposées (à confirmer) :**

| Type | Condition suggérée |
|------|-------------------|
| Maternité | Travailleur de sexe **F** uniquement |
| Prénatale | Travailleur de sexe **F** ; option : champ « date prévue accouchement » |
| Familiale | Travailleur ayant au moins 1 enfant à charge (champ à ajouter ?) ou pièce justificative obligatoire |

**Implémentation :**
- Validation dans `StoreDemandeRequest`
- Message clair si non éligible
- Filtrage des types disponibles dans le formulaire employeur

**Questions ouvertes :**
- [ ] Y a-t-il une durée minimale de cotisation ?
- [ ] Limite du nombre de demandes par période ?
- [ ] Documents obligatoires différents par type ?

---

### F04 — Déclaration multiple par l'employeur

**Statut :** ⬜ À faire

**Objectif :** Un employeur peut soumettre **plusieurs demandes** pour un même travailleur (types différents ou demandes successives).

**Existant :** Déjà techniquement possible (plusieurs lignes `demandes`), mais pas de UX dédiée.

**À ajouter :**
- [ ] Liste des demandes en cours par travailleur sur le dashboard employeur
- [ ] Empêcher doublon : même travailleur + même type + statut non terminal
- [ ] Bouton « Nouvelle demande » visible même si des demandes existent

---

### F05 — Consulter statut / détail du dossier

**Statut :** ⬜ À faire — **bug actuel signalé**

**Problème :** Pas de page `show` pour une demande ; le travailleur ne voit qu'un tableau sans détail ; pas de route « Consulter statut ».

**À implémenter :**
- Route + vue `entreprise.demandes.show`
- Route + vue `travailleur.demandes.show`
- Contenu : statut, dates, type, montant (si payée), documents, motif rejet, agent traitant

**Critères d'acceptation :**
- [ ] Clic sur une ligne de demande ouvre le détail
- [ ] Timeline ou fil des changements de statut
- [ ] Aucune erreur 404 / page blanche

---

### F06 — Réclamation travailleur

**Statut :** ⬜ À faire

**Objectif :** Permettre au travailleur de **contester** ou **demander un suivi** sur une demande rejetée ou bloquée.

**Proposition :**
- Table `reclamations` (demande_id, message, statut, created_at)
- Formulaire depuis la fiche demande (statut `rejetee` ou `en_verification` > X jours)
- Notification à l'agent APF / admin

---

### F07 — Lecteur PDF intégré

**Statut :** ⬜ À faire — **bug actuel signalé**

**Problème probable :**
- Lien `asset('storage/...')` sans `php artisan storage:link`
- Ouverture dans nouvel onglet au lieu d'un viewer in-app

**Solution proposée :**
- Route sécurisée `GET /documents/{demande}/{index}` avec contrôle d'accès
- Modal ou page dédiée avec **PDF.js** (Mozilla) ou `<iframe>`
- Vérifier `storage/app/public/documents`

**Critères d'acceptation :**
- [ ] PDF visible côté APF, employeur, admin
- [ ] Téléchargement optionnel
- [ ] Accès refusé si utilisateur non autorisé

---

### F08 — Logo CNSS & page d'accueil

**Statut :** ⬜ À faire

**Objectif :**
- Remplacer la redirection `/` → login par une **vraie page d'accueil**
- Afficher le **logo CNSS** + liens vers espaces (Employeur, Travailleur, APF, Admin)

**Fichiers :**
- `routes/web.php` (route `/`)
- Nouvelle vue `resources/views/home.blade.php`
- Asset : `public/images/logo-cnss.png` (à fournir ou placeholder)

---

### F09 — Notifications email

**Statut :** ⬜ À faire

**Déclencheurs :**
1. **Validation APF** → email employeur + travailleur
2. **Liquidation admin** → email employeur + travailleur (+ lien facture F11)

**Configuration (.env) — ne pas commiter les secrets :**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="CNSS"
```

**Implémentation Laravel :**
- `DemandeValideeNotification`, `DemandeLiquideeNotification`
- Mailables + queues (optionnel `ShouldQueue`)
- Modèles `Entreprise`, `Travailleur` : vérifier champs `email`

---

### F10 — Notifications SMS (optionnel)

**Statut :** ⬜ À faire (phase 2)

**Prérequis :** API SMS (Twilio, AfricasTalking, etc.) + numéros valides sur travailleurs/employeurs.

**Note :** Peut réutiliser les mêmes événements que F09.

---

### F11 — Facture PDF après liquidation

**Statut :** ⬜ À faire

**Contenu facture suggéré :**
- N° facture, date, logo CNSS
- Bénéficiaire (travailleur), entreprise
- Type allocation, montant FC, référence demande
- Signature / cachet admin

**Stack :** `barryvdh/laravel-dompdf` ou `spatie/laravel-pdf`

**Déclenchement :** À la création de `Liquidation` + bouton « Télécharger facture » sur fiche demande payée.

---

### F12 — Rapports statistiques

**Statut :** ⬜ À faire

**Indicateurs proposés :**
- Demandes par statut / par type / par période
- Montant total liquidé (mois, trimestre, année)
- Top entreprises, délais moyens de traitement
- Taux d'approbation / rejet

**Formats :** Page admin + export PDF / Excel (CSV minimum)

**Fichiers :**
- `Admin\RapportController`
- Vues avec graphiques (Chart.js déjà possible sur dashboard)

---

## Journal d'avancement

| Date | ID | Action | Par |
|------|----|--------|-----|
| 2026-06-17 | — | Création du document de suivi | — |

---

## Prochaine étape

**Choisir la fonctionnalité à attaquer en premier.**

Recommandation : commencer par **F01 (statuts)** + **F05 (consulter statut)**, car ils débloquent l'affichage correct pour employeur et travailleur, puis enchaîner **F02 (montants)**.

---

## Notes techniques

- **Guards auth :** `administrateur`, `entreprise`, `travailleur`, `apf`
- **Documents :** JSON array dans `demandes.documents`, stockage `public/documents`
- **Liquidation :** table `liquidations` liée 1:1 à `demandes`
