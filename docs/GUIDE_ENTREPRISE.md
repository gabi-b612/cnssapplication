# Guide Entreprise — Espace Employeur

← [Retour au guide principal](../GUIDE_UTILISATION.md)

---

## Connexion

| | |
|---|---|
| **URL** | `http://localhost:8000/entreprise/login` |

> **Pas de compte par défaut.** L'administrateur crée votre entreprise (voir [Guide Administrateur — Entreprises](GUIDE_ADMINISTRATEUR.md#2-gestion-des-entreprises)). Utilisez l'email et le mot de passe définis à la création.

1. Page d'accueil → carte **Espace Employeur**
2. Email + mot de passe → **Se connecter**
3. **Déconnexion** : icône en bas du menu latéral

---

## Rôle de l'entreprise

L'employeur :
1. **Enregistre** ses travailleurs
2. **Soumet** des demandes d'allocation pour eux (avec documents PDF)
3. **Suit** l'évolution de chaque demande

---

## Menu latéral

| Menu | Description |
|------|-------------|
| Dashboard | Statistiques et demandes en cours |
| Mes Travailleurs | Gérer les salariés |
| Mes Demandes | Liste et détail des demandes |
| Nouvelle Demande | Soumettre une allocation |

---

## 1. Tableau de bord

**URL :** `/entreprise/dashboard`

Affiche :
- Nombre de travailleurs
- Total demandes, en cours, approuvées, rejetées
- Les 10 dernières demandes en cours (cliquables)

---

## 2. Mes Travailleurs

**URL :** `/entreprise/travailleurs`

### Ajouter un travailleur

1. **Ajouter un travailleur**
2. Remplissez :

| Champ | Obligatoire | Exemple |
|-------|-------------|---------|
| Nom | Oui | Mukendi |
| Postnom | Oui | Ilunga |
| Prénom | Oui | Alice |
| Email | Oui | alice@test.local |
| Téléphone | Non | +243... |
| Date de naissance | Oui | 15/03/1990 |
| Sexe | Oui | M ou F |
| État civil | Non | Mariée |
| Mot de passe | Oui (min. 8 car.) | Travailleur@123 |
| Confirmer | Oui | Travailleur@123 |

3. **Enregistrer**

> **Sexe F** : allocations familiale, maternité et prénatale  
> **Sexe M** : allocation familiale uniquement

### Modifier un travailleur

1. Icône **crayon**
2. Modifiez les champs (mot de passe vide = inchangé)
3. **Enregistrer**

### Supprimer un travailleur

1. Icône **poubelle** → confirmer

---

## 3. Mes Demandes

**URL :** `/entreprise/demandes`

Liste paginée : référence, travailleur, type, statut, date.

### Détail d'une demande

Cliquez sur une ligne pour voir :
- Statut (badge coloré)
- Montant de référence ou montant versé
- Documents PDF consultables
- Historique des changements de statut
- Agent APF traitant
- **Télécharger la facture** (si statut **Payée**)

---

## 4. Nouvelle Demande

**URL :** `/entreprise/demandes/create`

### Prérequis

- Au moins **1 travailleur** enregistré
- Fichiers **PDF** prêts (max **2 Mo** chacun)

### Règles

| Règle | Détail |
|-------|--------|
| Éligibilité | M → familiale seule ; F → familiale, maternité, prénatale |
| Doublon | 1 seule demande active par type et par travailleur |
| Documents | Minimum 1 PDF obligatoire |
| Format | PDF uniquement |

### Soumettre — étape par étape

1. Menu **Nouvelle Demande**
2. Sélectionnez le **travailleur**
3. Choisissez le **type d'allocation** (options selon le sexe)
4. Le **montant de référence** s'affiche automatiquement
5. Joignez un ou plusieurs **PDF**
6. **Soumettre la demande**

**Résultat :** statut **Soumise** → l'agent APF prend le relais.

### Messages d'erreur possibles

| Message | Solution |
|---------|----------|
| Allocation réservée aux femmes | Choisir « familiale » ou un autre travailleur |
| Demande déjà en cours | Attendre la clôture de l'ancienne |
| Fichier trop volumineux | PDF ≤ 2 Mo |
| Format non accepté | Convertir en PDF |

---

## Emails reçus

L'entreprise reçoit un email quand :
- Une demande est **approuvée** par l'APF
- Une demande est **liquidée** (payée) par l'admin

(L'email de l'entreprise doit être renseigné à la création du compte.)

---

## Voir aussi

- [Guide principal — Scénario complet](../GUIDE_UTILISATION.md#9-scénario-complet--du-début-à-la-fin)
- [Guide APF](GUIDE_APF.md) — traitement des demandes
- [Guide Travailleur](GUIDE_TRAVAILLEUR.md) — vue côté salarié
