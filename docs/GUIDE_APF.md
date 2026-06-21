# Guide APF — Agent des Prestations aux Familles

← [Retour au guide principal](../GUIDE_UTILISATION.md)

---

## Connexion

| | |
|---|---|
| **URL** | `http://localhost:8000/apf/login` |
| **Compte 1** | `apf1@cnss.local` / `Admin@123` |
| **Compte 2** | `apf2@cnss.local` / `Admin@123` |

1. Page d'accueil → carte **Espace APF**
2. Email + mot de passe → **Se connecter**
3. **Déconnexion** : icône en bas du menu latéral

---

## Rôle de l'agent APF

L'agent APF **examine** les demandes soumises par les entreprises et **décide** de les approuver ou de les rejeter, après consultation des documents PDF joints.

```
Demande SOUMISE → APF examine → APPROUVÉE ou REJETÉE
```

Une demande **approuvée** est ensuite liquidée (payée) par l'**administrateur**.

---

## Menu latéral

| Menu | Description |
|------|-------------|
| Dashboard | Statistiques des demandes |
| Demandes à traiter | File d'attente à examiner |

---

## 1. Tableau de bord

**URL :** `/apf/dashboard`

Statistiques :
- **En attente** : demandes soumises + en vérification
- **Approuvées** : total des demandes validées
- **Rejetées** : total des demandes refusées

---

## 2. Demandes à traiter

**URL :** `/apf/demandes-a-traiter`

### Colonnes du tableau

| Colonne | Contenu |
|---------|---------|
| Réf. | Numéro (#ID) |
| Travailleur | Nom complet |
| Entreprise | Raison sociale |
| Type | familiale / maternite / prenatale |
| Documents | Liens **PDF** cliquables |
| Date | Date de soumission |
| Actions | Bouton **Traiter** |

### Traiter une demande — étape par étape

1. **Consultez les documents PDF** en cliquant sur les liens (s'ouvrent dans le navigateur)
2. Cliquez **Traiter** sur la ligne concernée
3. Une fenêtre s'ouvre avec :
   - Travailleur, entreprise, type d'allocation
   - **Montant de référence** (en FC)
   - Zone **Motif du rejet** (obligatoire en cas de rejet)

4. Choisissez une action :

#### Approuver

- Cliquez **Approuver**
- Statut → **Approuvée**
- Emails de notification envoyés à l'entreprise et au travailleur

#### Rejeter

- Rédigez le **motif du rejet** (obligatoire)
- Cliquez **Rejeter**
- Statut → **Rejetée**
- Le motif est visible par l'entreprise et le travailleur

### Comportement automatique

- Si la demande est **Soumise**, l'APF la passe d'abord en **En vérification**, puis applique la décision
- L'agent APF connecté est enregistré comme **agent traitant** sur la demande

---

## Montants de référence

| Type | Montant par défaut |
|------|-------------------|
| Allocation familiale | 24 300 FC |
| Allocation maternité | 72 000 FC |
| Allocation prénatale | 16 200 FC |

Ces montants sont indicatifs — la liquidation finale est faite par l'administrateur.

---

## Ce que l'APF ne fait pas

| Action | Qui s'en charge |
|--------|-----------------|
| Créer des entreprises | Administrateur |
| Enregistrer des travailleurs | Entreprise |
| Soumettre des demandes | Entreprise |
| Liquider (payer) | Administrateur |
| Traiter les réclamations | Non implémenté (stockées seulement) |

---

## Voir aussi

- [Guide principal — Statuts](../GUIDE_UTILISATION.md#10-les-statuts-dune-demande)
- [Guide Entreprise](GUIDE_ENTREPRISE.md) — qui soumet les demandes
- [Guide Administrateur — Liquidations](GUIDE_ADMINISTRATEUR.md#5-liquidations)
