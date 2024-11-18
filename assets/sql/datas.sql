-- Insertion dans la table "Role"
INSERT INTO Role (nom) VALUES ('Admin'), ('Client');


-- Insertion dans la table "Job"
INSERT INTO Job (nom) VALUES ('Développeur'), ('Designer'), ('Manager');

-- Insertion dans la table "type_evaluation"
INSERT INTO type_evaluation (nom, maximum, minimum)
VALUES 
    ('Technique', 10.0, 0.0),
    ('Communication', 5.0, 0.0);

-- Insertion dans la table "Evaluation"
INSERT INTO Evaluation (idcandidature, idtypeEvaluation, note, dateEvaluation)
VALUES 
    (1, 1, 8.5, '2024-11-14'),
    (1, 2, 4.0, '2024-11-14'),
    (2, 1, 7.0, '2024-11-15');

-- Insertion dans la table "embauche"
INSERT INTO embauche (dateEmbauche, idcandidature)
VALUES 
    ('2024-11-20', 1);

-- Insertion dans la table "notifications"
INSERT INTO notifications (textNotif, etat, dateheure)
VALUES 
    ('Nouvelle candidature reçue', FALSE, '2024-11-14 10:00:00'),
    ('Entretien programmé pour le poste de développeur', FALSE, '2024-11-15 14:30:00');
