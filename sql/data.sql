CREATE DATABASE IF NOT EXISTS project_manager;
USE project_manager;

CREATE TABLE IF NOT EXISTS membres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_debut DATE NOT NULL,
    date_fin DATE,
    budget DECIMAL(10,2) DEFAULT 0.00,
    statut ENUM('en_attente', 'en_cours', 'termine', 'annule') DEFAULT 'en_attente',
    type_projet ENUM('court', 'long') NOT NULL,
    membre_id INT NOT NULL,
    duree_jours INT,
    priorite ENUM('Basse', 'Moyenne', 'Haute'),
    FOREIGN KEY (membre_id) REFERENCES membres(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS activites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    date_activite DATETIME NOT NULL,
    duree_heures DECIMAL(4,2) NOT NULL,
    statut ENUM('planifiee', 'en_cours', 'terminee', 'annulee') DEFAULT 'planifiee',
    projet_id INT NOT NULL,
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE
);