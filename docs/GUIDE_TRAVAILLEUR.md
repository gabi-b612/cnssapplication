# Guide Travailleur — Espace Salarié

← [Retour au guide principal](../GUIDE_UTILISATION.md)

---

## Connexion

| | |
|---|---|
| **URL** | `http://localhost:8000/travailleur/login` |

> **Pas de compte par défaut.** Votre employeur (entreprise) crée votre compte dans **Mes Travailleurs** (voir [Guide Entreprise](GUIDE_ENTREPRISE.md#2-mes-travailleurs)).

1. Page d'accueil → carte **Espace Travailleur**
2. Email + mot de passe → **Se connecter**
3. **Déconnexion** : icône en bas du menu latéral

---

## Rôle du travailleur

Le travailleur peut :
- **Consulter** ses demandes d'allocation
- **Suivre** l'historique des statuts
- **Télécharger** la facture PDF (demande payée)
- **Déposer une réclamation** (demande rejetée ou en vérification)

> Le travailleur **ne soumet pas** de demande — c'est l'**entreprise** qui le fait pour lui.

---

## Menu latéral

| Menu | Description |
|------|-------------|
| Tableau de bord | Infos personnelles + liste des demandes |
| Mes Demandes | Lien vers la section demandes du tableau de bord |

---

## 1. Tableau de bord

**URL :** `/travailleur/dashboard`

Affiche :
- Vos informations (nom, email, etc.)
- Votre **entreprise employeur**
- **Mes demandes** : toutes vos demandes d'allocation

Cliquez sur une demande pour accéder au **détail**.

---

## 2. Détail d'une demande

**URL :** `/travailleur/demandes/{id}`

### Informations visibles

| Élément | Description |
|---------|-------------|
| Référence | Numéro #ID |
| Statut | Badge coloré (Soumise, Approuvée, Payée, etc.) |
| Type | familiale / maternité / prénatale |
| Montant | Référence ou montant versé (si payée) |
| Entreprise | Employeur |
| Documents | PDF consultables |
| Historique | Timeline de tous les changements de statut |
| Facture | Bouton **Télécharger la facture** (si **Payée**) |

### Statuts possibles

| Statut | Signification pour vous |
|--------|-------------------------|
| Soumise | Votre employeur a déposé la demande |
| En vérification | Un agent APF examine le dossier |
| Approuvée | Dossier validé — en attente de paiement |
| Rejetée | Refusée — motif visible, réclamation possible |
| Payée | Montant versé — facture disponible |

---

## 3. Déposer une réclamation

Disponible **uniquement** si la demande est :
- **Rejetée**, ou
- **En vérification**

### Étapes

1. Ouvrez le **détail** de la demande
2. Section **Déposer une réclamation**
3. Rédigez votre message :
   - Minimum **10 caractères**
   - Maximum **2000 caractères**
4. **Envoyer la réclamation**

**Résultat :** réclamation enregistrée avec statut **En attente**.

### Mes réclamations

Sur la même page, section **Mes réclamations** :
- Date et heure d'envoi
- Statut : **En attente** ou **Traitée**
- Contenu du message

> **Note :** Le traitement des réclamations par l'admin/APF n'est pas encore disponible dans l'interface — elles sont stockées pour suivi futur.

---

## Emails reçus

Le travailleur reçoit un email quand :
- Sa demande est **approuvée**
- Sa demande est **liquidée** (payée)

(L'email doit être renseigné par l'entreprise à la création du compte.)

---

## Voir aussi

- [Guide principal — Statuts](../GUIDE_UTILISATION.md#10-les-statuts-dune-demande)
- [Guide Entreprise](GUIDE_ENTREPRISE.md) — qui crée votre compte et soumet les demandes
- [Guide APF](GUIDE_APF.md) — qui valide les demandes
