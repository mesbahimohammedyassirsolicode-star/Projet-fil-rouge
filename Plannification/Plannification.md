# Planification du Projet :  E-commerce (Vêtements Femme)
## 1.  Phase 1 : Analyse & Conception (1 – 2 semaines)
**🎯 Objectif :

Comprendre le besoin et préparer la structure du site.

🔹 Tâches :
Analyse du cahier des charges
Définition des personas (clientes cibles)
Création des User Stories
Exemple :
En tant que cliente, je veux voir les produits pour choisir un article.
Conception des maquettes (UI/UX) :
Page Accueil
Catalogue
Détail produit
Panier
Checkout
Outils: figma ,stitch(insperation)
## 2.  Phase 2 : Design UI (1 semaine)
** Objectif :
Créer un design moderne et attractif (UI First)
Tâches :
Choix des couleurs (ex: rose, beige, noir élégant)
Typographie moderne
Création des composants :
Cards produits
Boutons
Navbar
Footer
Responsive design (mobile + desktop
## 2.1 Phase2.1 :  Conception Base de Données 
**  Objectif : 
Quelles données spécifiques sont stockées dans la base de données conformément au cahier des charges ?
**Tâches :
analyse de fonctionnalités:
Catalogue produits (abaya)
Panier
Commande
Utilisateur
Définir  les données nécessaires:
Produit (nom, prix, taille…)
Client (nom, email…)
Commande
 Résultat :Liste des entités + attributs
 ## 2.2 Phase 2.2 : Modélisation Conceptuelle (MCD) (2 – 3 jours)
 ** Objectif :
 Conception des relations entre les entités sans code
 **Tâches:
 Définir entités:
User
Produit
Catégorie
Commande
Détail_commande
*Définir relations:
User → Commande (1,N)
Commande → Détail (1,N)
Produit → Catégorie (N,1)
**Outils : Draw.io
## 2.3 Phase 2.3 : Modélisation Logique (MLD) (2 jours)
**Objectif: Conversion de MCD en tables relationnelles
** Tâches :
Conversion des entités en tables
Ajout de clés primaires (PK)
Ajout de clés étrangères (FK)
## 2.4 Phase 2.4 : Implémentation Physique (SQL) (2 – 3 jours)
** Objectif : Créer la base de données
** Tâches:
 CREATE TABLE
Définir les types (INT, VARCHAR…)
Ajouter des contraintes :
NOT NULL
UNIQUE
FOREIGN KEY
** Outils : MySQL (XAMPP)
phpMyAdmin
** Résultat : Base de données done
## 3. Phase 3 : Développement Front-End (2 semaines)
** 🎯 Objectif :

Transformer le design en pages web fonctionnelles

** Technologies :
HTML5
CSS3 (Flexbox / Grid)
JavaScript
** Pages à développer :
Home page
Catalogue
Détail produit
Panier
** Fonctionnalités :
Affichage dynamique (JS)
Ajout au panier (LocalStorage)
## 4. Phase 4 : Développement Back-End (2 semaines)
** Objectif :
Gérer les données et la logique métier
** Technologies :
PHP 
MySQL (XAMPP)
** Fonctionnalités :
Connexion PHP ↔ MySQL (PDO)
Récupération des produits depuis DB
Gestion des produits (CRUD)
Gestion des utilisateurs
Gestion des commandes
Connexion / inscription
Gestion du panier réel
Simulation du checkout
## 6.  Phase 6 : Tests & Validation (1 semaine)
** Objectif :

Vérifier que tout fonctionne correctement

** Tests :
Test des pages
Test du panier
Test du checkout
Responsive (mobile)