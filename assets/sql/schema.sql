CREATE DATABASE talents;
\c talents;
-- Création de la table "TypeChamp"
CREATE TABLE TypeChamp (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque type de champ
    nom VARCHAR(255) NOT NULL   -- Nom du type de champ
);

-- Création de la table "Role"
CREATE TABLE Role (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque rôle
    nom VARCHAR(255) NOT NULL   -- Nom du rôle
);

-- Création de la table "Personne"
CREATE TABLE Personne (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque personne
    nom VARCHAR(255) NOT NULL,  -- Nom de la personne
    email VARCHAR(255) UNIQUE NOT NULL,  -- Email unique de la personne
    mdp VARCHAR(255) NOT NULL,  -- Mot de passe (crypté, dans un vrai cas)
    phone VARCHAR(20),          -- Numéro de téléphone
    datenaissance DATE NOT NULL,  -- Date de naissance
    idrole INTEGER REFERENCES Role(id) ON DELETE SET NULL  -- Référence au rôle de la personne
);

-- Création de la table "Job"
CREATE TABLE Job (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque job
    nom VARCHAR(255) NOT NULL   -- Nom du job
);

-- Création de la table "Offre"
CREATE TABLE Offre (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque offre
    idpersonne INTEGER REFERENCES Personne(id) ON DELETE CASCADE,  -- Personne qui propose l'offre
    idjob INTEGER REFERENCES Job(id) ON DELETE SET NULL,  -- Job associé à l'offre
    dateOffre DATE NOT NULL,    -- Date de l'offre
    salaire NUMERIC(10, 2) NOT NULL,  -- Salaire proposé
    isTaken boolean default false
);

-- Création de la table "Candidature"
CREATE TABLE Candidature (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque candidature
    idpersonne INTEGER REFERENCES Personne(id) ON DELETE CASCADE,  -- Personne qui fait la candidature
    idOffre INTEGER REFERENCES Offre(id) ON DELETE CASCADE,  -- Offre à laquelle la personne a candidaté
    dateCandidature DATE NOT NULL,  -- Date de la candidature
    isTaken boolean default false
);

-- Création de la table "Requis"
CREATE TABLE Requis (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque exigence
    nom VARCHAR(255) NOT NULL,  -- Nom de l'exigence
    idtypechamp INTEGER REFERENCES TypeChamp(id) ON DELETE SET NULL  -- Type de champ de l'exigence
);

-- Création de la table "RequisOffre"
CREATE TABLE RequisOffre (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque exigence liée à une offre
    idoffre INTEGER REFERENCES Offre(id) ON DELETE CASCADE,  -- Offre concernée
    idrequis INTEGER REFERENCES Requis(id) ON DELETE CASCADE,  -- Exigence liée à l'offre
    minimum VARCHAR(255),       -- Valeur minimale exigée en texte
    maximum VARCHAR(255)        -- Valeur maximale exigée en texte
);

-- Création de la table "Profile"
CREATE TABLE Profile (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque profil
    idpersonne INTEGER REFERENCES Personne(id) ON DELETE CASCADE,  -- Personne concernée par le profil
    idrequis INTEGER REFERENCES Requis(id) ON DELETE CASCADE,  -- Exigence associée
    valeur VARCHAR(255) NOT NULL  -- Valeur renseignée par la personne dans son profil
);
ALTER TABLE Profile
ADD CONSTRAINT unique_profile UNIQUE (idpersonne, idrequis);

CREATE TABLE type_evaluation(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    maximum NUMERIC(4,2) NOT NULL default 0,
    minimum NUMERIC(4,2) NOT NULL default 0
);

CREATE TABLE Evaluation (
    id SERIAL PRIMARY KEY,
    note NUMERIC(4,2) not NULL,
    idcandidature INTEGER REFERENCES Candidature(id) ON DELETE CASCADE,
    idtype INTEGER REFERENCES type_evaluation(id) ON DELETE CASCADE
);
