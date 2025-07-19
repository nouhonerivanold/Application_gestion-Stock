-- CREATE TYPE StatutCommande AS ENUM ('validee', 'annulee');



CREATE TYPE StatutFacture AS ENUM ('attente', 'partielle', 'totale');
CREATE TYPE RoleEmploye AS ENUM ('admin', 'magasinier', 'vendeur');

CREATE TYPE ClientType AS(
    nom VARCHAR(100),
    prenom VARCHAR(100),
    telephone VARCHAR(50),
    ville VARCHAR(100),
    quartier VARCHAR(100)
);

CREATE TYPE UniteType AS(
	intitule VARCHAR(50)
);

CREATE TABLE Unite (
    idUnite SERIAL PRIMARY KEY,
    intitule VARCHAR(50) NOT NULL
);


CREATE TABLE Produit (
    idProduit SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    prixU INTEGER NOT NULL,
    qteStock INTEGER NOT NULL,
    qteMin INTEGER NOT NULL,
    image TEXT,
    idUnite INTEGER NOT NULL REFERENCES Unite(idUnite),
	unite UniteType NOT NULL,
    idProduitRef INTEGER REFERENCES Produit(idProduit)
);

CREATE TABLE Lot (
    idLot SERIAL PRIMARY KEY,
    idProduit INTEGER NOT NULL REFERENCES Produit(idProduit),
    qte INTEGER NOT NULL,
    dateProduction DATE NOT NULL,
    dateExpiration DATE NOT NULL
);


CREATE TABLE Client(
    idClient SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(50),
    ville VARCHAR(100),
    quartier VARCHAR(100)
);

CREATE TABLE Commande (
    idCommande SERIAL PRIMARY KEY,
    idClient INTEGER REFERENCES Client(idClient),
    date DATE NOT NULL,
    statut StatutFacture NOT NULL
);

CREATE TABLE LigneCommande (
    idProduit INTEGER NOT NULL REFERENCES Produit(idProduit),
    idCommande INTEGER NOT NULL REFERENCES Commande(idCommande),
    qte INTEGER NOT NULL,
    PRIMARY KEY (idProduit, idCommande)
);

CREATE TABLE FactureClient (
    idFacture SERIAL PRIMARY KEY,
    idClient INTEGER REFERENCES Client(idClient),
    infosClient ClientType,
    idCommande INTEGER NOT NULL REFERENCES Commande(idCommande),
    statut StatutFacture NOT NULL,
    montantPayee INTEGER,
    montantTotale INTEGER,
	date DATE NOT NULL
);

CREATE TABLE Employe (
    idEmploye SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    adresse TEXT,
    telephone VARCHAR(15),
    email VARCHAR(100) NOT NULL UNIQUE,
    role RoleEmploye NOT NULL,
    mot_passe VARCHAR(100),
    photo TEXT
);

CREATE TABLE Fournisseur (
    idFournisseur SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    telephone VARCHAR(50),
    ville VARCHAR(100),
    quartier VARCHAR(100)
);

CREATE TABLE CommandeFournisseur (
    idCommandeFour SERIAL PRIMARY KEY,
    idEmploye INTEGER NOT NULL REFERENCES Employe(idEmploye),
    idFournisseur INTEGER NOT NULL REFERENCES Fournisseur(idFournisseur),
    date DATE NOT NULL,
    statut StatutFacture NOT NULL
);

CREATE TABLE LigneCommandeFour (
    idCommandeFour INTEGER NOT NULL REFERENCES CommandeFournisseur(idCommandeFour),
    idProduit INTEGER NOT NULL REFERENCES Produit(idProduit),
    qteCommandee INTEGER NOT NULL,
    PRIMARY KEY (idCommandeFour, idProduit)
);

CREATE TABLE BonReception (
    idReception SERIAL PRIMARY KEY,
    idCommandeFour INTEGER NOT NULL REFERENCES CommandeFournisseur(idCommandeFour),
    dateReception DATE NOT NULL
);

CREATE TABLE LigneBonReception (
    idCommandeFour INTEGER NOT NULL,
    idProduit INTEGER NOT NULL,
    idReception INTEGER NOT NULL REFERENCES BonReception(idReception),
    qteRecu INTEGER NOT NULL,
    prixAchat INTEGER NOT NULL,
    PRIMARY KEY (idReception, idCommandeFour, idProduit),
    FOREIGN KEY (idCommandeFour, idProduit) REFERENCES LigneCommandeFour(idCommandeFour, idProduit)
);


CREATE TABLE FactureFour (
    idFactureF SERIAL PRIMARY KEY,
    statut StatutFacture NOT NULL,
    idFournisseur INTEGER NOT NULL REFERENCES Fournisseur(idFournisseur),
    montantPayee INTEGER,
    montantTotale INTEGER,
	date DATE NOT NULL
);