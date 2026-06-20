# Guide Administrateur — Espace CNSS

← [Retour au guide principal](../GUIDE_UTILISATION.md)

---

## Connexion

| | |
|---|---|
| **URL** | `http://localhost:8000/login` |
| **Compte 1** | `admin@cnss.local` / `Admin@123` |
| **Compte 2** | `marie.kabila@cnss.local` / `Admin@123` |

1. Page d'accueil → carte **Administration**, ou URL directe ci-dessus
2. Saisissez email et mot de passe → **Se connecter**
3. **Déconnexion** : icône en bas du menu latéral gauche

---

## Menu latéral

| Menu | Description |
|------|-------------|
| Dashboard | Statistiques globales |
| Entreprises | CRUD entreprises employeuses |
| Travailleurs | Liste globale (lecture seule) |
| Demandes validées | Demandes approuvées ou payées |
| Liquidations | Payer les demandes approuvées |
| Rapports | Statistiques et export CSV |

**Pages accessibles par URL** (non listées dans le menu) :

- Agents APF : `/admin/apfs`
- Administrateurs : `/admin/administrateurs`
- Configuration : `/admin/configuration`

---

## 1. Tableau de bord

**URL :** `/admin/dashboard`

Statistiques affichées :
- Nombre d'entreprises, gestionnaires RH, agents APF
- Nombre de demandes, demandes approuvées, liquidations, travailleurs

Liens rapides vers Entreprises, Agents APF, Historique des liquidations.

---

## 2. Gestion des entreprises

**URL :** `/admin/entreprises`

### Voir la liste

Tableau : raison sociale, email, téléphone, actions.

### Ajouter une entreprise

1. Cliquez **Ajouter une entreprise**
2. Remplissez le formulaire :

| Champ | Obligatoire | Exemple |
|-------|-------------|---------|
| Raison sociale | Oui | SARL Congo Tech |
| Siège social | Oui | Kinshasa, Gombe |
| Email | Oui | entreprise@test.local |
| Téléphone | Non | +243 900 000 000 |
| Mot de passe | Oui (min. 8 car.) | Entreprise@123 |
| Confirmer mot de passe | Oui | Entreprise@123 |

3. Cliquez **Créer**

> L'email servira à la connexion dans l'**Espace Employeur**.

### Voir le détail

Icône **œil** → informations entreprise, liste travailleurs, liste demandes.

### Modifier

1. Icône **crayon**
2. Modifiez les champs
3. Mot de passe : laissez **vide** pour ne pas le changer
4. **Enregistrer**

### Supprimer

1. Icône **poubelle** → confirmer

> **Attention :** supprime aussi les travailleurs et demandes de l'entreprise.

---

## 3. Gestion des travailleurs (consultation)

**URL :** `/admin/travailleurs`

Liste **tous** les travailleurs de toutes les entreprises.

L'administrateur **ne crée pas** les travailleurs ici — c'est le rôle de l'**entreprise** (voir [Guide Entreprise](GUIDE_ENTREPRISE.md)).

---

## 4. Demandes validées

**URL :** `/admin/demandes-validees`

Liste les demandes au statut **Approuvée** ou **Payée** pour un suivi global.

---

## 5. Liquidations

**URL :** `/admin/liquidations`

### Liquider une demande approuvée

1. Repérez la demande dans le tableau
2. Cliquez **Liquider**
3. Remplissez la fenêtre :

| Champ | Description |
|-------|-------------|
| Montant (FC) | Pré-rempli — modifiable |
| Justification | **Obligatoire** si montant ≠ montant suggéré |
| Date de liquidation | Date du paiement (≤ aujourd'hui) |

4. **Confirmer la liquidation**

**Résultat :**
- Statut → **Payée**
- Facture PDF générée (`FAC-2026-00001`, etc.)
- Emails envoyés à l'entreprise et au travailleur

### Historique des liquidations

**URL :** `/admin/liquidations/historique`

Accès : lien en bas de la page Liquidations.

| Action | Description |
|--------|-------------|
| Icône facture | Télécharger le PDF |
| Icône œil | Voir le détail |
| Icône poubelle | Supprimer (demande repasse en **Approuvée**) |

---

## 6. Rapports statistiques

**URL :** `/admin/rapports`

### Filtrer

1. **Date début** et **Date fin**
2. **Filtrer**

### Données affichées

- Total demandes, montant liquidé, taux d'approbation/rejet
- Répartition par statut et par type
- Top 5 entreprises

### Exporter CSV

1. Définir la période
2. **Exporter CSV** → fichier ouvrable dans Excel

Colonnes : ID, Date, Entreprise, Travailleur, Type, Statut, Montant liquidé.

---

## 7. Gestion des agents APF

**URL :** `/admin/apfs`  
Accès rapide : Dashboard → carte **Agents APF** → **Gérer**

### Ajouter un agent APF

1. **Ajouter un agent APF**
2. Nom, Prénom, Email, Mot de passe (+ confirmation)
3. **Créer**

### Modifier / Supprimer

- **Crayon** : modifier (mot de passe optionnel)
- **Poubelle** : supprimer (avec confirmation)

---

## 8. Gestion des administrateurs

**URL :** `/admin/administrateurs`

Mêmes actions que pour les APF : lister, voir détail, modifier, supprimer.

---

## 9. Configuration des paramètres

**URL :** `/admin/configuration`

| Paramètre | Valeur par défaut |
|-----------|-------------------|
| Taux de cotisation (%) | 6,5 % |
| Allocation familiale (FC) | 24 300 |
| Allocation maternité (FC) | 72 000 |
| Allocation prénatale (FC) | 16 200 |

1. Modifiez les valeurs
2. **Enregistrer les paramètres**

> S'applique aux **futures** demandes et liquidations.

---

## Voir aussi

- [Guide principal — Scénario complet](../GUIDE_UTILISATION.md#9-scénario-complet--du-début-à-la-fin)
- [Guide APF](GUIDE_APF.md) — validation des demandes
- [Guide Entreprise](GUIDE_ENTREPRISE.md) — soumission des demandes
