CREATE DATABASE IF NOT EXISTS projet_fil_rouge;
USE projet_fil_rouge;

CREATE TABLE client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prénom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    téléphone VARCHAR(20),
    password VARCHAR(50) NOT NULL
);

CREATE TABLE Catégorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

CREATE TABLE products (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(50),
    taille VARCHAR(50),
    couleur VARCHAR(20),
    id_categorie INT,
    FOREIGN KEY (id_categorie) REFERENCES Catégorie(id_categorie) ON DELETE SET NULL
);

CREATE TABLE Commande (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    datecmd DATETIME DEFAULT CURRENT_TIMESTAMP,
    statuscmd VARCHAR(20) DEFAULT 'En attente',
    id_client INT,
    FOREIGN KEY (id_client) REFERENCES client(id_client) ON DELETE CASCADE
);

CREATE TABLE ligne_commande (
    id_ligne INT AUTO_INCREMENT PRIMARY KEY,
    Qté INT NOT NULL DEFAULT 1,
    Prix DECIMAL(10, 2) NOT NULL,
    id_commande INT,
    id_produit INT,
    FOREIGN KEY (id_commande) REFERENCES Commande(id_commande) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES products(id_produit) ON DELETE CASCADE
);