\c postgres;
DROP DATABASE talents;

CREATE DATABASE talents;

\c talents;
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
    dateCreation DATE NOT NULL,    -- Date de l'offre
    dateFin DATE NOT NULL,
    exigence TEXT       -- Exigence pour l'offre
);

-- Création de la table "cv"
CREATE TABLE cv (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque CV
    idpersonne INTEGER REFERENCES Personne(id) ON DELETE CASCADE,  -- Personne à laquelle le CV appartient
    competence TEXT NOT NULL,   -- Compétences de la personne
    note_competence INTEGER NOT NULL,
    experience TEXT NOT NULL,   -- Expériences de la personne
    note_experience INTEGER NOT NULL,
    education TEXT NOT NULL,     -- Formation de la personne
    note_education INTEGER NOT NULL,
    remarque TEXT,
    chemin VARCHAR(255) NOT NULL
);

-- Création de la table "Candidature"
CREATE TABLE Candidature (
    id SERIAL PRIMARY KEY,      -- Identifiant unique pour chaque candidature
    idcv INTEGER REFERENCES cv(id) ON DELETE CASCADE,  -- CV de la personne qui postule
    idOffre INTEGER REFERENCES Offre(id) ON DELETE CASCADE,  -- Offre à laquelle la personne a candidaté
    datePostule DATE NOT NULL,  -- Date de la candidature
    etat BOOLEAN DEFAULT FALSE  -- Statut de la candidature
);

-- Création de la table "type_evaluation"
CREATE TABLE type_evaluation (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    maximum NUMERIC(4,2) NOT NULL DEFAULT 0,
    minimum NUMERIC(4,2) NOT NULL DEFAULT 0
);

-- Création de la table "Evaluation"
CREATE TABLE Evaluation (
    id SERIAL PRIMARY KEY,
    idcandidature INTEGER REFERENCES Candidature(id) ON DELETE CASCADE,
    idtypeEvaluation INTEGER REFERENCES type_evaluation(id) ON DELETE CASCADE,
    note NUMERIC(4,2) NOT NULL,
    dateEvaluation DATE NOT NULL  -- Date de l'évaluation
);

-- Création de la table "embauche"
CREATE TABLE embauche (
    id SERIAL PRIMARY KEY,
    dateEmbauche DATE NOT NULL,  -- Date de l'embauche
    idcandidature INTEGER REFERENCES Candidature(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    idpersonne INTEGER REFERENCES Personne(id) ON DELETE CASCADE,
    textenotif TEXT NOT NULL,
    etat INTEGER NOT NULL default 0,
    dateheure_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP
);


CREATE OR REPLACE VIEW v_cv_dashboard AS
SELECT 
    c.id AS id_candidature,
    p.id AS id_personne,
    p.nom AS nom_personne,
    j.nom AS nom_job,
    c.idcv AS id_cv,
    c.idoffre AS id_offre,
    o.idpersonne AS id_recruteur,  -- Ajout de l'id du recruteur
    cv.note_competence AS note_competence,
    cv.note_experience AS note_experience,
    cv.note_education AS note_education,
    ROUND((cv.note_competence + cv.note_experience + cv.note_education) / 3.0, 2) AS moyenne_notes,
    c.datePostule,
    c.etat
FROM 
    Candidature c
JOIN 
    cv ON c.idcv = cv.id
JOIN 
    Personne p ON cv.idpersonne = p.id
JOIN 
    Offre o ON c.idOffre = o.id
JOIN 
    Job j ON o.idJob = j.id;

    -- Table: Statut (table vaovao)
CREATE TABLE Statut (
    id SERIAL PRIMARY KEY,
    label VARCHAR(50) NOT NULL
);

-- Table: Statut_Preavis (table vaovao)
CREATE TABLE Statut_Preavis (
    id SERIAL PRIMARY KEY,
    label VARCHAR(50) NOT NULL
);

-- Table: Statut_Paiement (table vaovao)
CREATE TABLE Statut_Paiement (
    id SERIAL PRIMARY KEY,
    label VARCHAR(50) NOT NULL
);

-- Table: Type_Rupture (table afa)
CREATE TABLE Type_Rupture (
    id SERIAL PRIMARY KEY,
    label VARCHAR(50) NOT NULL
);

-- Table: Contrat
CREATE TABLE Contrat (
    id SERIAL PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE,
    salaire Decimal(11,2) not null,
    statut_id INT NOT NULL REFERENCES Statut(id),
    candidature_id INT NOT NULL REFERENCES candidature(id),
    employe_id INT NOT NULL REFERENCES personne(id), 
    employeur_id INT NOT NULL REFERENCES personne(id)
);

-- Table: RuptureContrat
CREATE TABLE RuptureContrat (
    id SERIAL PRIMARY KEY,
    contrat_id INT NOT NULL REFERENCES Contrat(id),
    date_rupture DATE NOT NULL,
    type_rupture_id INT NOT NULL REFERENCES Type_Rupture(id)
);

-- Table: Preavis
CREATE TABLE Preavis (
    id SERIAL PRIMARY KEY,
    rupture_id INT NOT NULL REFERENCES RuptureContrat(id),
    date_debut DATE NOT NULL,
    date_fin DATE,
    statut_preavis_id INT NOT NULL REFERENCES Statut_Preavis(id)
);

-- Table: IndemnitePreavis
CREATE TABLE IndemnitePreavis (
    id SERIAL PRIMARY KEY,
    preavis_id INT NOT NULL REFERENCES Preavis(id),
    montant DECIMAL(15, 2) NOT NULL,
    date_paiement DATE,
    statut_paiement_id INT NOT NULL REFERENCES Statut_Paiement(id)
);

-- Insérer les valeurs initiales dans les tables de référence
INSERT INTO Statut (label) VALUES ('Actif'), ('Resilié');
INSERT INTO Statut_Preavis (label) VALUES ('En cours'), ('Non respecter'), ('Terminer');
INSERT INTO Statut_Paiement (label) VALUES ('En attente'), ('Régle');
INSERT INTO Type_Rupture (label) VALUES ('Licenciement'), ('Demission');