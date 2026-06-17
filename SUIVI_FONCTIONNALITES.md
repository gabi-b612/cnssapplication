# Suivi des mises à jour — Application CNSS

> Document de pilotage pour implémenter les fonctionnalités **une par une**, sans tout faire en même temps.
>
> **Dernière mise à jour :** 17 juin 2026

---

## État actuel du projet (résumé)

| Élément | Existant aujourd'hui | Cible demandée |
|--------|----------------------|----------------|
| Statuts demande | ✅ 6 statuts + historique | Brouillon → Soumise → En vérification → Approuvée → Payée / Rejetée |
| Montants allocations | ✅ Montants fixes FC en config | Maternité **72 000 FC**, familiale **24 300 FC**, prénatale **16 200 FC** |
| Déclaration employeur | ✅ Plusieurs demandes par travailleur (types distincts) | Plusieurs demandes possibles par travailleur |
| Éligibilité | ✅ Filtre sexe + validation serveur | Maternité/prénatale réservées aux travailleuses |
| PDF | ✅ Route sécurisée, ouverture nouvel onglet | Consultation PDF fiable |
| Notifications | ✅ Email approbation + liquidation | Email à la validation et à la liquidation |
| Page d'accueil | ✅ Page `/` avec logo + liens espaces | Page d'accueil CNSS avec logo |
| Rapports | ✅ Rapports statistiques + export CSV | Rapports statistiques exportables |
| Facture | ✅ PDF facture après liquidation | PDF facture après liquidation |
| Réclamations | ✅ Formulaire travailleur | Réclamation sur demande rejetée / en vérification |

---

## Ordre d'implémentation recommandé

| # | ID | Fonctionnalité | Priorité | Statut |
|---|----|----------------|----------|--------|
| 1 | F01 | Refonte du cycle de vie des statuts | 🔴 Haute | ✅ Fait |
| 2 | F02 | Montants fixes & calcul des allocations | 🔴 Haute | ✅ Fait |
| 3 | F05 | Consulter statut / détail dossier | 🔴 Haute | ✅ Fait |
| 4 | F08 | Logo CNSS & page d'accueil | 🟢 Facile | ✅ Fait |
| 5 | F03 | Conditions d'éligibilité par type | 🟠 Moyenne | ✅ Fait |
| 6 | F04 | Déclaration multiple (employeur) | 🟠 Moyenne | ✅ Fait |
| 7 | F07 | Consultation PDF (nouvel onglet) | 🔴 Haute | ✅ Fait |
| 8 | F09 | Notifications email | 🔴 Haute | ✅ Fait |
| 9 | F11 | Génération facture PDF | 🟠 Moyenne | ✅ Fait |
| 10 | F12 | Rapports statistiques | 🟠 Moyenne | ✅ Fait |
| 11 | F06 | Réclamation travailleur | 🟡 Basse | ✅ Fait |

> **F10 (SMS)** — supprimé du périmètre, non prévu.

---

## Détail par fonctionnalité

### F01 — Cycle de vie des statuts

**Statut :** ✅ Fait

**Critères d'acceptation :**
- [x] Migration des anciennes valeurs
- [x] Badges cohérents sur employeur, travailleur, APF, admin
- [x] Historique des changements de statut

---

### F02 — Montants fixes & calcul des allocations

**Statut :** ✅ Fait

**Montants de référence (configurables en admin) :**

| Type | Montant (FC) |
|------|-------------|
| Allocation maternité | 72 000 |
| Allocation familiale | 24 300 |
| Allocation prénatale | 16 200 |

**Critères d'acceptation :**
- [x] Montant affiché à la création / validation selon le type
- [x] Montant proposé automatiquement lors de la liquidation
- [x] Cohérence FC partout

---

### F03 — Conditions d'éligibilité

**Statut :** ✅ Fait

- Service `App\Services\DemandeEligibilityService`
- Maternité et prénatale réservées aux travailleuses (`sexe = F`)
- Validation côté serveur dans `StoreDemandeRequest`
- Filtrage dynamique des types dans le formulaire de création (Alpine.js)

---

### F04 — Déclaration multiple par l'employeur

**Statut :** ✅ Fait

- Un travailleur peut avoir plusieurs demandes de types différents
- Blocage d'un doublon : même travailleur + même type tant que la demande n'est pas payée ou rejetée
- Tableau « Demandes en cours » sur le dashboard employeur

---

### F05 — Consulter statut / détail du dossier

**Statut :** ✅ Fait

**Critères d'acceptation :**
- [x] Clic sur une ligne de demande ouvre le détail
- [x] Timeline des changements de statut
- [x] Aucune erreur 404 / page blanche

---

### F06 — Réclamation travailleur

**Statut :** ✅ Fait

- Table `reclamations` (message, statut en_attente / traitee)
- Formulaire sur la fiche demande (statuts `rejetee` ou `en_verification`)
- Route `POST travailleur/demandes/{demande}/reclamations`

---

### F07 — Consultation PDF

**Statut :** ✅ Fait (approche simplifiée)

- Route sécurisée `documents.show` avec contrôle d'accès par rôle
- Ouverture du PDF dans un **nouvel onglet** du navigateur (`target="_blank"`)
- Lien symbolique `storage` requis : `php artisan storage:link`

---

### F08 — Logo CNSS & page d'accueil

**Statut :** ✅ Fait

- Route `/` → `home.blade.php`
- Logo : `public/img/logo-CNSS.png`
- Liens vers Employeur, Travailleur, APF, Admin

---

### F09 — Notifications email

**Statut :** ✅ Fait

- **Approbation APF** → `DemandeApprouveeNotification` → employeur + travailleur
- **Liquidation admin** → `DemandeLiquideeNotification` → employeur + travailleur (+ lien facture)
- Config SMTP dans `.env` (voir `.env.example`)

### F11 — Facture PDF après liquidation

**Statut :** ✅ Fait

- Numéro facture auto `FAC-YYYY-NNNNN` à la liquidation
- Template `resources/views/pdf/facture.blade.php` (DomPDF)
- Téléchargement via `GET /factures/{liquidation}` (employeur, travailleur, admin)
- Bouton sur la fiche détail demande payée

---

### F12 — Rapports statistiques

**Statut :** ✅ Fait

- Page admin `/admin/rapports` : totaux, répartition par statut/type, top entreprises
- Filtre par période (date début / fin)
- Export CSV `GET /admin/rapports/export`

---

## Journal d'avancement

| Date | ID | Action | Par |
|------|----|--------|-----|
| 2026-06-17 | — | Création du document de suivi | — |
| 2026-06-17 | F01, F05 | Statuts + fiches détail employeur/travailleur | — |
| 2026-06-17 | F02, F08 | Montants fixes FC + page d'accueil | — |
| 2026-06-17 | F07, F09 | PDF nouvel onglet + notifications email | — |
| 2026-06-17 | F03, F04, F06, F11, F12 | Éligibilité, doublons, facture, rapports, réclamations | — |

---

## Prochaine étape

**Toutes les fonctionnalités du périmètre sont implémentées.** Tests manuels recommandés avant mise en production.

---

## Notes techniques

- **Guards auth :** `administrateur`, `entreprise`, `travailleur`, `apf`
- **Documents :** route `GET /documents/{demande}/{index}`, stockage `storage/app/public/documents`
- **Factures :** route `GET /factures/{liquidation}`, génération DomPDF
- **Emails :** `App\Notifications\DemandeApprouveeNotification`, `DemandeLiquideeNotification`
- **Liquidation :** table `liquidations` liée 1:1 à `demandes`, colonne `numero_facture`
- **Montants :** `App\Services\AllocationCalculator` + colonnes `montant_allocation_*` dans `configurations`
- **Éligibilité :** `App\Services\DemandeEligibilityService`
- **Réclamations :** table `reclamations`, modèle `App\Models\Reclamation`
