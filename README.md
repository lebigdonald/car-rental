# Plateforme CarRental

CarRental est une plateforme complète de location de voitures conçue pour simplifier le processus de location de véhicules. Ce dépôt contient le code source du site web et du panneau d'administration.

## 1. Lien vers l’application web déployée

L'application est accessible à l'adresse suivante :
[https://votre-url-de-deploiement.com](https://votre-url-de-deploiement.com)

*(Remplacez ce lien par l'URL réelle de votre déploiement)*

## 2. Architecture et Choix Techniques

### Architecture
Le projet suit l'architecture **MVC (Modèle-Vue-Contrôleur)** imposée par le framework Laravel. Cette structure permet une séparation claire des responsabilités :
- **Modèles (Models)** : Gèrent les données et la logique métier (Eloquent ORM).
- **Vues (Views)** : Gèrent l'interface utilisateur (Blade Templating).
- **Contrôleurs (Controllers)** : Gèrent les requêtes entrantes et font le lien entre les modèles et les vues.

### Choix Techniques
- **Backend** : [Laravel 10](https://laravel.com/) (PHP). Choisi pour sa robustesse, sa sécurité et sa facilité de développement.
- **Frontend** : [Bootstrap 5](https://getbootstrap.com/) et HTML/CSS personnalisé. Choisi pour sa réactivité et sa facilité de mise en page.
- **Base de données** : [MySQL](https://www.mysql.com/). Système de gestion de base de données relationnelle standard et performant.
- **Authentification** : Système d'authentification intégré de Laravel avec des gardes (guards) séparés pour les utilisateurs (`web`) et les administrateurs (`admin`).
- **Graphiques** : [Chart.js](https://www.chartjs.org/) pour la visualisation des données dans le tableau de bord administrateur.
- **Emails** : Utilisation du système de notification de Laravel pour l'envoi d'emails transactionnels (confirmation de location, rejet, contact).

## 3. Instructions de Déploiement et d’Utilisation

### Prérequis
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (optionnel, pour la compilation des assets si nécessaire)

### Installation Locale

1.  **Cloner le dépôt**
    ```bash
    git clone https://github.com/votre-utilisateur/car-rental.git
    cd car-rental
    ```

2.  **Installer les dépendances PHP**
    ```bash
    composer install
    ```

3.  **Configurer l'environnement**
    - Copiez le fichier `.env.example` vers `.env` :
      ```bash
      cp .env.example .env
      ```
    - Ouvrez le fichier `.env` et configurez vos informations de base de données (DB_DATABASE, DB_USERNAME, DB_PASSWORD) et de mail (MAIL_MAILER, etc.).

4.  **Générer la clé d'application**
    ```bash
    php artisan key:generate
    ```

5.  **Créer le lien symbolique pour le stockage**
    ```bash
    php artisan storage:link
    ```
    *Si cela ne fonctionne pas, vous pouvez visiter la route `/fix-storage` une fois le serveur lancé.*

6.  **Exécuter les migrations et les seeders**
    ```bash
    php artisan migrate --seed
    ```
    *Cela créera les tables et insérera des données de test (utilisateurs, voitures, admins).*

    **Comptes par défaut créés par les seeders :**
    - **Administrateur** :
        - Nom d'utilisateur : `admin`
        - Mot de passe : `password`
    - **Utilisateur** :
        - Email : `john@example.com`
        - Mot de passe : `password`

7.  **Lancer le serveur de développement**
    ```bash
    php artisan serve
    ```

8.  **Accéder à l'application**
    - Site web utilisateur : `http://localhost:8000`
    - Panneau d'administration : `http://localhost:8000/admin`

### Utilisation

#### Côté Utilisateur
- **Inscription/Connexion** : Créez un compte ou connectez-vous.
- **Parcourir les voitures** : Utilisez les filtres pour trouver le véhicule idéal.
- **Louer une voiture** : Sélectionnez une voiture, choisissez vos dates et validez la demande.
- **Historique** : Consultez vos locations passées et en cours, et téléchargez vos factures (si payées).
- **Contact** : Utilisez le formulaire de contact pour envoyer un message à l'administration.

#### Côté Administrateur
- **Connexion** : Connectez-vous via l'interface admin.
- **Tableau de bord** : Visualisez les statistiques clés (revenus, locations actives, graphiques).
- **Gestion des voitures** : Ajoutez, modifiez ou supprimez des véhicules.
- **Gestion des locations** : Approuvez ou rejetez les demandes de location.
- **Gestion des utilisateurs** : Gérez les comptes utilisateurs et ajoutez d'autres administrateurs.

## 4. Tests

Le projet inclut une suite complète de tests unitaires et d'intégration pour assurer la stabilité et la fiabilité de l'application.

### Types de Tests
- **Tests Unitaires (Unit Tests)** : Vérifient le bon fonctionnement des méthodes individuelles et de la logique métier (ex: scopes des modèles).
- **Tests d'Intégration (Feature Tests)** : Vérifient le bon fonctionnement des fonctionnalités complètes, incluant les requêtes HTTP, l'accès à la base de données et l'authentification (ex: processus de location, gestion des voitures par l'admin).

### Lancer les Tests

Pour exécuter tous les tests, utilisez la commande suivante à la racine du projet :

```bash
php artisan test
```

Vous pouvez également lancer un fichier de test spécifique :

```bash
php artisan test tests/Feature/RentalProcessTest.php
```

## Fonctionnalités Clés

- **Système de Réservation** : Vérification Automatique de la disponibilité des véhicules pour éviter les conflits de dates.
- **Facturation** : Génération automatique de factures PDF pour les locations payées.
- **Notifications** : Envoi d'emails automatiques lors de l'approbation ou du rejet d'une location.
- **Sécurité** : Protection des routes par middleware, validation des entrées, et protection CSRF.

## Auteurs

- **Donald NKENGFACK** - *Senior Software Developer*

## Licence

Ce projet est sous licence [MIT](LICENSE).
