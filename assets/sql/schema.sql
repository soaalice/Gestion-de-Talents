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



-- Heure sup
CREATE TABLE HeuresSupplementaires (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES Employe(id), -- Référence vers l'employé
    date DATE NOT NULL, -- Date de l'heure supplémentaire
    heures_travail DECIMAL(5, 2) NOT NULL, -- Nombre d'heures supplémentaires
    CHECK (heures_travail > 0) -- Validation : le nombre d'heures doit être positif
);

CREATE OR REPLACE FUNCTION verifier_limite_heures_sup()
RETURNS TRIGGER AS $$
DECLARE
    total_heures NUMERIC(5, 2);
BEGIN
    -- Calculer le total des heures supplémentaires de l'employé dans la même semaine
    SELECT COALESCE(SUM(heures_travail), 0)
    INTO total_heures
    FROM HeuresSupplementaires
    WHERE employe_id = NEW.employe_id
      AND DATE_TRUNC('week', date) = DATE_TRUNC('week', NEW.date);

    -- Vérifier si le total actuel + la nouvelle heure dépasse 20
    IF total_heures + NEW.heures_travail > 20 THEN
        RAISE EXCEPTION 'Limite hebdomadaire dépassée : % heures supplémentaires déjà enregistrées pour cet employé.', total_heures;
    END IF;

    RETURN NEW; -- Permet l'insertion si la limite n'est pas dépassée
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_verifier_limite_heures_sup
BEFORE INSERT ON HeuresSupplementaires
FOR EACH ROW
EXECUTE FUNCTION verifier_limite_heures_sup();


----------------------------------------

CREATE TABLE TypesJours (
    id SERIAL PRIMARY KEY,
    type_label VARCHAR(50) NOT NULL UNIQUE, -- Nom du type (dimanche, férié, etc.)
    description VARCHAR(255) -- Description facultative
);

INSERT INTO TypesJours (type_label, description)
VALUES 
    ('dimanche', 'Jour travaillé le dimanche'),
    ('ferie', 'Jour férié officiel'),
    ('autre', 'Autres jours spéciaux non définis');

CREATE TABLE HeuresSpeciales (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES Employe(id),
    date DATE NOT NULL, -- Date spécifique de l'heure spéciale
    type_jour_id INT NOT NULL REFERENCES TypesJours(id), -- Référence au type de jour
    heures_travail DECIMAL(5, 2) NOT NULL -- Nombre d'heures travaillées
);
