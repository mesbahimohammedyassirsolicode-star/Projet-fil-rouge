# Projet-fil-rouge

Ceci est un projet de site e-commerce complet pour une boutique de vêtements femme, avec une application PHP nommée `sabaya`.

## Description

Le dossier principal `sabaya/` contient une boutique en ligne pour une marque de mode modeste, avec une interface client et un panneau administrateur.

### Fonctionnalités principales

- Site vitrine avec catalogue de produits
- Pages de produits et catégories
- Panier et processus de commande
- Gestion des commandes et historique client
- Wishlist
- Formulaire de contact
- Authentification utilisateur (inscription, connexion, profil)
- Administration complète : produits, catégories, commandes, messages, utilisateurs
- Support multilingue (Français / Anglais)

## Structure du projet

- `sabaya/`
  - `auth/` : pages de connexion, inscription, profil, déconnexion
  - `admin/` : back-office pour la gestion des produits, catégories, commandes, messages et utilisateurs
  - `assets/` : styles CSS, scripts JavaScript, images
  - `config/` : configuration de la base de données et gestion des langues
  - `contact/` : formulaire de contact et gestion des messages
  - `includes/` : en-têtes, pieds de page, barre de navigation et notifications
  - `lang/` : fichiers de traduction pour le français et l’anglais
  - `models/` : classes PHP pour les entités de la base de données
  - `products/` : pages du catalogue, panier, paiement, commandes et recherche
  - `wishlist/` : gestion de la liste de souhaits
  - `index.php`, `about.php` : pages publiques principales

## Base de données

La base de données est gérée par MySQL / MariaDB. Le schéma se trouve dans `Conception BD/base.sql`.

### Configuration

- Modifier les paramètres de connexion dans `sabaya/config/Database.php`
- Exemple :

```php
private $host = "localhost";
private $db_name = "sabaya";
private $username = "root";
private $password = "";
```

## Installation locale

1. Copier le dossier `sabaya` dans le répertoire web de votre serveur local.
2. Créer une base de données MySQL, par exemple `sabaya`.
3. Importer le schéma SQL depuis `Conception BD/base.sql`.
4. Mettre à jour les informations de connexion dans `sabaya/config/Database.php`.
5. Accéder au site via `http://localhost/sabaya/`.

## Recommandations

- Ajouter un fichier `.env` pour stocker les variables de configuration en dehors du code
- Ajouter une protection CSRF sur les formulaires
- Sécuriser l’accès admin avec un système de permissions renforcé
- Ajouter un fichier `LICENSE` si vous souhaitez définir des conditions d’utilisation

## Notes

- Le code est principalement écrit en PHP procédural avec PDO pour la base de données.
- Il n’y a pas de gestionnaire de dépendances comme Composer par défaut.
- Le projet est structuré pour un site e-commerce simple et modulable.
