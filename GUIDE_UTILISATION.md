# Guide d'utilisation — Application CNSS

**Caisse Nationale de Sécurité Sociale (RDC)**  
Plateforme de gestion des demandes d'allocations familiales, de maternité et prénatales.

---

Ce document est le **guide principal**. Il explique comment installer, lancer l'application et comprendre le fonctionnement global.

> **Guides par acteur** (détail de chaque espace) :
>
> | Rôle | Fichier |
> |------|---------|
> | Administrateur | [docs/GUIDE_ADMINISTRATEUR.md](docs/GUIDE_ADMINISTRATEUR.md) |
> | Agent APF | [docs/GUIDE_APF.md](docs/GUIDE_APF.md) |
> | Entreprise (Employeur) | [docs/GUIDE_ENTREPRISE.md](docs/GUIDE_ENTREPRISE.md) |
> | Travailleur | [docs/GUIDE_TRAVAILLEUR.md](docs/GUIDE_TRAVAILLEUR.md) |

> **Public visé :** utilisateurs finaux sur Windows, y compris personnes peu familiarisées avec l'informatique.

---

## Table des matières

1. [Ce dont vous avez besoin](#1-ce-dont-vous-avez-besoin)
2. [Installation du projet](#2-installation-du-projet)
3. [Vérifier que XAMPP est opérationnel](#3-vérifier-que-xampp-est-opérationnel)
4. [Lancer l'application (2 terminaux)](#4-lancer-lapplication-2-terminaux)
5. [Ouvrir l'application dans le navigateur](#5-ouvrir-lapplication-dans-le-navigateur)
6. [Comptes de connexion par défaut](#6-comptes-de-connexion-par-défaut)
7. [Vue d'ensemble de l'application](#7-vue-densemble-de-lapplication)
8. [Les 4 espaces utilisateurs](#8-les-4-espaces-utilisateurs)
9. [Scénario complet : du début à la fin](#9-scénario-complet--du-début-à-la-fin)
10. [Les statuts d'une demande](#10-les-statuts-dune-demande)
11. [Les types d'allocations et montants](#11-les-types-dallocations-et-montants)
12. [Les emails automatiques](#12-les-emails-automatiques)
13. [Messages d'erreur fréquents](#13-messages-derreur-fréquents)
14. [Arrêter l'application](#14-arrêter-lapplication)
15. [Récapitulatif des URLs](#15-récapitulatif-des-urls)

---

## 1. Ce dont vous avez besoin

| Élément | Rôle | Comment vérifier |
|---------|------|------------------|
| **XAMPP** | Fournit **PHP** | XAMPP Control Panel, Apache démarré |
| **Node.js** | Interface graphique (`npm run dev`) | Taper `node -v` dans cmd |
| **Navigateur web** | Chrome, Edge ou Firefox | — |
| **Fichier ZIP du projet** | Application pré-configurée | Fourni par votre administrateur |

> Le projet est livré **prêt à l'emploi** : base de données, comptes admin/APF, emails, etc. Aucune configuration supplémentaire requise.

---

## 2. Installation du projet

### Étape 2.1 — Dézipper

1. **Clic droit** sur `cnssapplication.zip` → **Extraire tout…**
2. Un dossier `cnssapplication` est créé (ex. : `C:\Users\VotreNom\Documents\cnssapplication`)

### Étape 2.2 — Copier (optionnel)

1. **Clic droit** sur le dossier → **Copier** → **Coller** à l'emplacement souhaité (Bureau, disque D:, etc.)

### Étape 2.3 — Retenir le chemin

Vous devrez ouvrir un terminal **dans ce dossier** à l'étape 4.

---

## 3. Vérifier que XAMPP est opérationnel

1. Menu Démarrer → **XAMPP Control Panel**
2. Cliquez **Start** à côté de **Apache** (ligne verte = OK)

> MySQL n'est **pas nécessaire** — l'application utilise SQLite (fichier local).

3. Vérifiez PHP : **Windows + R** → `cmd` → Entrée → tapez :

```bat
php -v
```

Si « php n'est pas reconnu », utilisez : `C:\xampp\php\php.exe -v`

---

## 4. Lancer l'application (2 terminaux)

| Terminal | Commande | Rôle |
|----------|----------|------|
| **Terminal 1** | `php artisan serve` | Serveur web |
| **Terminal 2** | `npm run dev` | Styles et scripts |

> **Les deux fenêtres doivent rester ouvertes** pendant l'utilisation.

### Ouvrir un terminal dans le dossier du projet

1. Explorateur de fichiers → dossier `cnssapplication`
2. Barre d'adresse → tapez `cmd` → **Entrée**

### Terminal 1

```bat
php artisan serve
```

Résultat attendu : `Server running on [http://127.0.0.1:8000]`

### Terminal 2

Ouvrez une **deuxième** fenêtre cmd dans le même dossier :

```bat
npm run dev
```

### Problèmes fréquents au démarrage

| Problème | Solution |
|----------|----------|
| `php n'est pas reconnu` | `C:\xampp\php\php.exe artisan serve` |
| `npm n'est pas reconnu` | Installez Node.js LTS depuis [nodejs.org](https://nodejs.org) |
| Port 8000 occupé | `php artisan serve --port=8001` |

---

## 5. Ouvrir l'application dans le navigateur

1. Ouvrez Chrome, Edge ou Firefox
2. Adresse : `http://localhost:8000` ou `http://127.0.0.1:8000`
3. Vous voyez la page d'accueil avec **4 cartes** : Employeur, Travailleur, APF, Administration

---

## 6. Comptes de connexion par défaut

**Mot de passe commun :** `Admin@123`

| Rôle | Email | Connexion |
|------|-------|-----------|
| Admin 1 | admin@cnss.local | `/login` |
| Admin 2 | marie.kabila@cnss.local | `/login` |
| APF 1 | apf1@cnss.local | `/apf/login` |
| APF 2 | apf2@cnss.local | `/apf/login` |

Les comptes **Entreprise** et **Travailleur** sont créés via l'application (voir scénario ci-dessous).

---

## 7. Vue d'ensemble de l'application

### Cycle de vie d'une demande

```
Entreprise soumet une demande (+ documents PDF)
        ↓
Agent APF examine → Approuve ou Rejette
        ↓
Administrateur liquide (paie) la demande approuvée
        ↓
Facture PDF — statut « Payée »
```

### Les 4 rôles

| Rôle | Guide détaillé |
|------|----------------|
| **Administrateur** | [docs/GUIDE_ADMINISTRATEUR.md](docs/GUIDE_ADMINISTRATEUR.md) |
| **APF** | [docs/GUIDE_APF.md](docs/GUIDE_APF.md) |
| **Entreprise** | [docs/GUIDE_ENTREPRISE.md](docs/GUIDE_ENTREPRISE.md) |
| **Travailleur** | [docs/GUIDE_TRAVAILLEUR.md](docs/GUIDE_TRAVAILLEUR.md) |

---

## 8. Les 4 espaces utilisateurs

| Carte (accueil) | URL | Identifiants |
|-----------------|-----|--------------|
| Espace Employeur | `/entreprise/login` | Email + mot de passe entreprise |
| Espace Travailleur | `/travailleur/login` | Email + mot de passe travailleur |
| Espace APF | `/apf/login` | Email + mot de passe APF |
| Administration | `/login` | Email + mot de passe admin |

**Connexion :** email → mot de passe → **Se connecter**  
**Déconnexion :** icône porte de sortie en bas du menu latéral gauche

---

## 9. Scénario complet : du début à la fin

Démonstration idéale pour tester **toutes** les fonctionnalités.

### Étape A — Admin crée une entreprise

→ Voir [Guide Administrateur — Entreprises](docs/GUIDE_ADMINISTRATEUR.md#2-gestion-des-entreprises)

1. Connexion : `admin@cnss.local` / `Admin@123`
2. Menu **Entreprises** → **Ajouter une entreprise**
3. Exemple : SARL Congo Tech, `entreprise@test.local`, mot de passe `Entreprise@123`

### Étape B — Entreprise enregistre un travailleur

→ Voir [Guide Entreprise — Travailleurs](docs/GUIDE_ENTREPRISE.md#2-mes-travailleurs)

1. Déconnexion admin → **Espace Employeur**
2. Connexion avec le compte entreprise
3. **Mes Travailleurs** → **Ajouter un travailleur**

### Étape C — Entreprise soumet une demande

→ Voir [Guide Entreprise — Nouvelle demande](docs/GUIDE_ENTREPRISE.md#4-nouvelle-demande)

1. **Nouvelle Demande** → travailleur + type + PDF → **Soumettre**

### Étape D — APF traite la demande

→ Voir [Guide APF — Demandes à traiter](docs/GUIDE_APF.md#2-demandes-à-traiter)

1. Connexion APF : `apf1@cnss.local` / `Admin@123`
2. **Demandes à traiter** → consulter PDF → **Traiter** → **Approuver** ou **Rejeter**

### Étape E — Admin liquide la demande

→ Voir [Guide Administrateur — Liquidations](docs/GUIDE_ADMINISTRATEUR.md#5-liquidations)

1. Connexion admin → **Liquidations** → **Liquider** → **Confirmer**

### Étape F — Travailleur consulte sa demande

→ Voir [Guide Travailleur](docs/GUIDE_TRAVAILLEUR.md)

1. Connexion travailleur → tableau de bord → détail → facture PDF si payée

---

## 10. Les statuts d'une demande

| Statut | Signification | Prochaine action |
|--------|---------------|------------------|
| **Soumise** | Déposée par l'entreprise | APF examine |
| **En vérification** | APF en cours d'examen | APF décide |
| **Approuvée** | Validée par l'APF | Admin liquide |
| **Rejetée** | Refusée (motif visible) | Travailleur peut réclamer |
| **Payée** | Liquidée, facture émise | Dossier clos |

```
SOUMISE → EN VÉRIFICATION → APPROUVÉE → PAYÉE
                         ↘ REJETÉE
```

---

## 11. Les types d'allocations et montants

| Type | Libellé | Éligibilité | Montant par défaut |
|------|---------|-------------|-------------------|
| familiale | Allocation familiale | Tous | 24 300 FC |
| maternite | Allocation maternité | Femmes (F) | 72 000 FC |
| prenatale | Allocation prénatale | Femmes (F) | 16 200 FC |

Modifiables par l'admin dans **Configuration** (`/admin/configuration`).

---

## 12. Les emails automatiques

| Événement | Destinataires |
|-----------|---------------|
| Demande **approuvée** | Entreprise + Travailleur |
| Demande **liquidée** | Entreprise + Travailleur |

Conditions : emails renseignés en base, SMTP déjà configuré dans le projet livré.

---

## 13. Messages d'erreur fréquents

### Au lancement

| Message | Solution |
|---------|----------|
| `php n'est pas reconnu` | `C:\xampp\php\php.exe` |
| `npm n'est pas reconnu` | Installer Node.js LTS |
| Page sans style | Relancer `npm run dev` |
| Port 8000 occupé | `php artisan serve --port=8001` |

### Documents PDF inaccessibles

Exécuter **une fois** dans le dossier du projet :

```bat
php artisan storage:link
```

---

## 14. Arrêter l'application

1. Terminal 1 → **Ctrl + C**
2. Terminal 2 → **Ctrl + C**
3. Fermer les fenêtres

Pour relancer : reprendre à la [section 4](#4-lancer-lapplication-2-terminaux).

---

## 15. Récapitulatif des URLs

| Page | URL |
|------|-----|
| Accueil | `http://localhost:8000` |
| Admin | `http://localhost:8000/login` |
| APF | `http://localhost:8000/apf/login` |
| Entreprise | `http://localhost:8000/entreprise/login` |
| Travailleur | `http://localhost:8000/travailleur/login` |

---

*Application CNSS — Laravel 13*
