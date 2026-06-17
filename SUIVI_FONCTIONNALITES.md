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
| Déclaration employeur | 1 demande = 1 travailleur + 1 type | Plusieurs demandes possibles par travailleur |
| PDF | Liens `storage/...` (ouverture externe) | Lecteur PDF intégré dans l'app |
| Notifications | Aucune | Email à la validation et à la liquidation |
| Page d'accueil | ✅ Page `/` avec logo + liens espaces | Page d'accueil CNSS avec logo |
| Rapports | Dashboard basique (compteurs) | Rapports statistiques exportables |
| Facture | Non | PDF facture après liquidation |

---

## Ordre d'implémentation recommandé

| # | ID | Fonctionnalité | Priorité | Statut |
|---|----|----------------|----------|--------|
| 1 | F01 | Refonte du cycle de vie des statuts | 🔴 Haute | ✅ Fait |
| 2 | F02 | Montants fixes & calcul des allocations | 🔴 Haute | ✅ Fait |
| 3 | F05 | Consulter statut / détail dossier | 🔴 Haute | ✅ Fait |
| 4 | F08 | Logo CNSS & page d'accueil | 🟢 Facile | ✅ Fait |
| 5 | F03 | Conditions d'éligibilité par type | 🟠 Moyenne | ⬜ À faire |
| 6 | F04 | Déclaration multiple (employeur) | 🟠 Moyenne | ⬜ À faire |
| 7 | F07 | Lecteur PDF intégré | 🔴 Haute | ⬜ À faire |
| 8 | F09 | Notifications email | 🔴 Haute | ⬜ À faire |
| 9 | F11 | Génération facture PDF | 🟠 Moyenne | ⬜ À faire |
| 10 | F12 | Rapports statistiques | 🟠 Moyenne | ⬜ À faire |
| 11 | F06 | Réclamation travailleur | 🟡 Basse | ⬜ À faire |

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

**Statut :** ⬜ À faire — **règles métier à valider**

---

### F04 — Déclaration multiple par l'employeur

**Statut :** ⬜ À faire

---

### F05 — Consulter statut / détail du dossier

**Statut :** ✅ Fait

**Critères d'acceptation :**
- [x] Clic sur une ligne de demande ouvre le détail
- [x] Timeline des changements de statut
- [x] Aucune erreur 404 / page blanche

---

### F06 — Réclamation travailleur

**Statut :** ⬜ À faire

---

### F07 — Lecteur PDF intégré

**Statut :** ⬜ À faire

---

### F08 — Logo CNSS & page d'accueil

**Statut :** ✅ Fait

- Route `/` → `home.blade.php`
- Logo : `public/img/logo-CNSS.png`
- Liens vers Employeur, Travailleur, APF, Admin

---

### F09 — Notifications email

**Statut :** ⬜ À faire

---

### F11 — Facture PDF après liquidation

**Statut :** ⬜ À faire

---

### F12 — Rapports statistiques

**Statut :** ⬜ À faire

---

## Journal d'avancement

| Date | ID | Action | Par |
|------|----|--------|-----|
| 2026-06-17 | — | Création du document de suivi | — |
| 2026-06-17 | F01, F05 | Statuts + fiches détail employeur/travailleur | — |
| 2026-06-17 | F02, F08 | Montants fixes FC + page d'accueil | — |
| 2026-06-17 | F10 | Retiré du périmètre (SMS non prévu) | — |

---

## Prochaine étape

**F07 (lecteur PDF)** ou **F03 (éligibilité)** — selon priorité métier.

---

## Notes techniques

- **Guards auth :** `administrateur`, `entreprise`, `travailleur`, `apf`
- **Documents :** JSON array dans `demandes.documents`, stockage `public/documents`
- **Liquidation :** table `liquidations` liée 1:1 à `demandes`
- **Montants :** `App\Services\AllocationCalculator` + colonnes `montant_allocation_*` dans `configurations`
