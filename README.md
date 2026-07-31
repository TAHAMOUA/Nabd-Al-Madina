# Nabd-Al-Madina

## Description

Nabd-Al-Madina est une plateforme de gestion des signalements urbains développée avec Laravel. Elle permet aux citoyens de signaler des incidents dans leur ville, aux agents de les traiter et au système d'utiliser l'intelligence artificielle pour améliorer leur classification.

## Fonctionnalités

### Authentification

* Inscription et connexion avec Laravel Sanctum.
* Gestion des rôles (Citoyen, Agent, Administrateur).

### Gestion des signalements

* Création d'un signalement.
* Modification et suppression.
* Consultation des signalements.
* Upload de photo.
* Mise à jour du statut.

### Gestion des incidents

* Création et validation des incidents.
* Association des signalements à un incident.

### Intelligence Artificielle

* Classification automatique des signalements.
* Génération automatique de :

  * Catégorie
  * Priorité
  * Niveau d'urgence
  * Résumé
  * Département responsable

### Détection des doublons

* Recherche des signalements similaires.
* Calcul d'un score de similarité.
* Proposition des doublons existants.

---

## Technologies

* PHP 8.x
* Laravel
* MySQL
* Laravel Sanctum
* OpenAI API
* REST API

---

## Installation

### Cloner le projet

```bash
git clone https://github.com/TAHAMOUA/Nabd-Al-Madina.git
cd Nabd-Al-Madina
```

### Installer les dépendances

```bash
composer install
```

### Copier le fichier d'environnement

```bash
cp .env.example .env
```

### Générer la clé

```bash
php artisan key:generate
```

### Configurer la base de données

Modifier le fichier `.env` :

```env
DB_DATABASE=nabd_al_madina
DB_USERNAME=root
DB_PASSWORD=
```

### Exécuter les migrations

```bash
php artisan migrate --seed
```

### Lancer le serveur

```bash
php artisan serve
```

---

## Endpoints principaux

### Auth

* POST `/api/register`
* POST `/api/login`

### Signalements

* GET `/api/signalements`
* POST `/api/signalements`
* GET `/api/signalements/{id}`
* PUT `/api/signalements/{id}`
* DELETE `/api/signalements/{id}`

### Intelligence Artificielle

* POST `/api/signalements/{id}/analyze`

### Détection des doublons

* GET `/api/signalements/{id}/similaires`

### Statut

* PATCH `/api/signalements/{id}/statut`

### Incidents

* GET `/api/incidents`
* POST `/api/incidents`
* POST `/api/incidents/validate-grouping`

### Départements

* GET `/api/departements`

---

## Structure du projet

```
app/
 ├── Http/
 ├── Models/
 ├── Policies/
 ├── Services/
 │     ├── SignalementAnalyzer.php
 │     └── DuplicateDetector.php

routes/
 └── api.php

database/
 ├── migrations/
 └── seeders/
```

---

## Équipe

* Personne 1 : Base de données, modèles, migrations, authentification
* Personne 2 : CRUD Signalement, API Resources, Upload photo
* Personne 3 : Rôles, Policies, Gestion des incidents
* Personne 4 : Intelligence artificielle, Classification automatique, Détection des doublons

---

## Licence

Projet réalisé dans le cadre d'un projet académique.
