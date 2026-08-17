-- Création de la base de données et sélection de celle-ci
CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE touche_pas_au_klaxon;

-- 1. Création de la table AGENCE (Sans clés étrangères, elle doit être créée en premier)
CREATE TABLE AGENCE (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- 2. Création de la table UTILISATEUR (Sans clés étrangères non plus)
CREATE TABLE UTILISATEUR (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20)
);

-- 3. Création de la table TRAJET (Contient les clés étrangères, elle est créée en dernier)
CREATE TABLE TRAJET (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    date_heure_depart DATETIME NOT NULL,
    date_heure_arrivee DATETIME NOT NULL,
    places_total INT NOT NULL,
    places_disponibles INT NOT NULL,
    id_utilisateur INT NOT NULL,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,
    
    -- Déclaration des liens (Clés étrangères)
    FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur),
    FOREIGN KEY (id_agence_depart) REFERENCES AGENCE(id_agence),
    FOREIGN KEY (id_agence_arrivee) REFERENCES AGENCE(id_agence)
);