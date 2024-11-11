INSERT INTO Role (nom) VALUES ('Recruteur');
INSERT INTO Role (nom) VALUES ('Postulant');

-- Insérer des types de champs dans la table TypeChamp
INSERT INTO TypeChamp (nom) VALUES
('varchar'),
('int'),
('numeric'),
('date'),
('timestamp'),;

-- Insérer des emplois dans la table Job
INSERT INTO Job (nom) VALUES
('Développeur Web'),
('Chef de projet'),
('Analyste de données'),
('Designer UX/UI'),
('Administrateur système'),
('Ingénieur logiciel'),
('Responsable marketing'),
('Chargé de recrutement'),
('Consultant en gestion'),
('Responsable des ventes');

-- Insérer des requis dans la table Requis
INSERT INTO Requis (nom, idtypechamp) VALUES
('expérience professionnelle', (SELECT id FROM TypeChamp WHERE nom = 'int')),
('âge', (SELECT id FROM TypeChamp WHERE nom = 'int')),
('nombre de diplômes', (SELECT id FROM TypeChamp WHERE nom = 'int')),
('niveau bac', (SELECT id FROM TypeChamp WHERE nom = 'int'));

-- Insérer les types d'évaluation (Test écrit et Test oral)
INSERT INTO type_evaluation (nom, maximum, minimum)
VALUES 
    ('Test écrit', 20.00, 0.00),  -- Le test écrit a une note entre 0 et 20
    ('Test oral', 20.00, 0.00);    -- Le test oral a également une note entre 0 et 20
