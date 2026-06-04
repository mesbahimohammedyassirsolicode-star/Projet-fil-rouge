CREATE DATABASE sabaya;
USE sabaya;

-- =========================
-- TABLE CLIENT
-- =========================
CREATE TABLE client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','client') DEFAULT 'client'
);

-- =========================
-- TABLE CATEGORIE
-- =========================
CREATE TABLE categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- =========================
-- TABLE PRODUITS
-- =========================
CREATE TABLE produits (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    taille VARCHAR(50),
    couleur VARCHAR(50),
    id_categorie INT,
    
    CONSTRAINT fk_produit_categorie
    FOREIGN KEY (id_categorie)
    REFERENCES categorie(id_categorie)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- =========================
-- TABLE COMMANDE
-- =========================
CREATE TABLE commande (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    datecmd DATETIME DEFAULT CURRENT_TIMESTAMP,
    statuscmd ENUM(
        'En attente',
        'Confirmée',
        'En préparation',
        'Expédiée',
        'Livrée'
    ) DEFAULT 'En attente',
    
    id_client INT NOT NULL,

    CONSTRAINT fk_commande_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABLE LIGNE_COMMANDE
-- =========================
CREATE TABLE ligne_commande (
    id_ligne INT AUTO_INCREMENT PRIMARY KEY,
    qte INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,

    id_commande INT NOT NULL,
    id_produit INT NOT NULL,

    CONSTRAINT fk_ligne_commande
    FOREIGN KEY (id_commande)
    REFERENCES commande(id_commande)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    CONSTRAINT fk_ligne_produit
    FOREIGN KEY (id_produit)
    REFERENCES produits(id_produit)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABLE ADRESSE
-- =========================
CREATE TABLE adresse (
    id_adresse INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(100) NOT NULL,
    adresse TEXT NOT NULL,
    code_postal VARCHAR(20),

    id_client INT NOT NULL,

    CONSTRAINT fk_adresse_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABLE WISHLIST
-- =========================
CREATE TABLE wishlist (
    id_wishlist INT AUTO_INCREMENT PRIMARY KEY,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,

    id_client INT NOT NULL,
    id_produit INT NOT NULL,

    CONSTRAINT fk_wishlist_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    CONSTRAINT fk_wishlist_produit
    FOREIGN KEY (id_produit)
    REFERENCES produits(id_produit)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABLE CONTACT
-- =========================
CREATE TABLE contact (
    id_contact INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_message DATETIME DEFAULT CURRENT_TIMESTAMP,

    id_client INT,

    CONSTRAINT fk_contact_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

-- =========================
-- CATEGORIES PAR DEFAUT
-- =========================
INSERT INTO categorie (nom) VALUES
('Abayas Casual'),
('Abayas Soirée'),
('Abayas Cérémonie'),
('Ensembles'),
('Khimar et Accessoires');

-- =========================
-- ADMIN PAR DEFAUT
-- =========================
INSERT INTO client
(nom, prenom, email, telephone, password, role)
VALUES
(
'Admin',
'Sabaya',
'admin@sabaya.com',
'0600000000',
'admin123',
'admin'
);