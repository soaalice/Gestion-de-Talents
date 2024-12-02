-- Insertion des rôles dans la table Role
INSERT INTO Role (nom) VALUES
('admin'),
('client');

-- Insertion des personnes dans la table Personne
INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole) VALUES
-- Admin
('Rasolo Andrianarivo', 'admin@example.com', '$2y$10$v1DqzNNXVZp6Afd.s/1YXewWJ8dx11GyfUZcuEjZEMLJ4Y5N6PYkq', '0340010101', '1980-01-01', 1),
-- Clients
('Rabe Rakoto', 'client1@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340020202', '1990-02-02', 2),
('Razafy Rasoarimanana', 'client2@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340030303', '1991-03-03', 2),
('Andry Ratsimba', 'client3@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340040404', '1992-04-04', 2),
('Faly Rakotomalala', 'client4@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340050505', '1993-05-05', 2),
('Tiana Randrianarisoa', 'client5@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340060606', '1994-06-06', 2),
('Hery Raharimanana', 'client6@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340070707', '1995-07-07', 2),
('Fanja Rasoanirina', 'client7@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340080808', '1996-08-08', 2),
('Miora Rabetokotany', 'client8@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340090909', '1997-09-09', 2),
('Eric Rabeson', 'client9@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340101010', '1998-10-10', 2),
('Hanitra Ralambomanana', 'client10@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340111111', '1999-11-11', 2),
('Lala Randriamampionona', 'client11@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340121212', '1985-01-12', 2),
('Haja Rafanomezantsoa', 'client12@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340131313', '1986-02-13', 2),
('Voahirana Razafindrakoto', 'client13@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340141414', '1987-03-14', 2),
('Tojo Ramanandafy', 'client14@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340151515', '1988-04-15', 2),
('Arisoa Ravelonarivo', 'client15@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340161616', '1989-05-16', 2),
('Solohery Rakotovao', 'client16@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340171717', '1990-06-17', 2),
('Vola Rakotonirina', 'client17@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340181818', '1991-07-18', 2),
('Mahery Rasoamanana', 'client18@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340191919', '1992-08-19', 2),
('Mamy Ramaroson', 'client19@example.com', '$2y$10$xNMzcihYOlRvUBj1v8hBUeXs7xZKyfImIfCUk2VwWjGkmFjwEwZFO', '0340202020', '1993-09-20', 2);



-- Insertion dans la table "Job"
-- Insertion des postes dans la table Job
INSERT INTO Job (nom) VALUES 
('Directeur general'),
('Directeur technique (CTO)'),
('Directeur des operations (COO)'),
('Directeur commercial'),
('Responsable commercial'),
('Business Developer'),
('Account Manager'),
('Responsable avant-vente'),
('Developpeur Back-end'),
('Developpeur Front-end'),
('Developpeur Full-stack'),
('Developpeur Mobile'),
('Architecte logiciel'),
('Ingenieur DevOps'),
('Ingenieur systeme et reseau'),
('Administrateur systeme'),
('Consultant ERP/CRM'),
('Expert en cybersécurité'),
('Data Scientist'),
('Data Engineer'),
('Ingenieur cloud'),
('Testeur/QA'),
('Chef de projet'),
('Scrum Master'),
('Product Owner'),
('PMO'),
('Consultant fonctionnel'),
('Consultant technique'),
('Consultant en transformation digitale'),
('Responsable RH'),
('Charge de recrutement'),
('Responsable communication'),
('Comptable/Controleur de gestion'),
('Charge de support client'),
('Expert en intelligence artificielle'),
('UX/UI Designer'),
('Consultant en IoT'),
('Expert blockchain');

 -- Insérer des données dans la table "cv"
INSERT INTO cv (idpersonne, competence, note_competence, experience, note_experience, education, note_education, remarque, chemin) VALUES
(2, 'PHP, JavaScript, SQL', 8, '3 ans en développement web', 7, 'Licence en Informatique', 9, 'Expert en backend', '/chemin/vers/cv1.pdf'),
(3, 'HTML, CSS, React', 7, '2 ans en front-end', 6, 'BTS Développement Web', 8, 'Bonne connaissance UI/UX', '/chemin/vers/cv2.pdf'),
(4, 'Python, Machine Learning', 9, '5 ans en Data Science', 10, 'Master en Intelligence Artificielle', 10, 'Data Scientist Senior', '/chemin/vers/cv3.pdf'),
(5, 'Gestion de projets, Agile', 8, '4 ans comme Chef de Projet', 8, 'MBA Management de Projets', 9, 'Scrum Master certifié', '/chemin/vers/cv4.pdf'),
(6, 'Linux, Sécurité réseau', 7, '3 ans en administration système', 7, 'Licence Sécurité Informatique', 8, 'Spécialiste cybersécurité', '/chemin/vers/cv5.pdf');

-- Insérer des offres fictives pour les candidatures (créées par un admin)
INSERT INTO Offre (idpersonne, idjob, dateCreation, dateFin, exigence) VALUES
(1, 9, '2021-12-01', '2022-12-31', 'Recherchons développeur Back-End expérimenté'),
(1, 10, '2022-01-01', '2022-12-31', 'Cherchons développeur Front-End pour projets modernes'),
(1, 19, '2022-06-01', '2023-12-31', 'Data Scientist pour projet IA complexe'),
(1, 22, '2022-11-01', '2024-12-31', 'Chef de projet Agile avec expérience internationale'),
(1, 18, '2023-03-01', '2025-01-01', 'Expert en cybersécurité pour audits et conseils');

-- Insérer des candidatures (faites par des clients)
INSERT INTO Candidature (idcv, idOffre, datePostule, etat) VALUES
(1, 1, '2022-01-15', TRUE),
(2, 2, '2022-02-10', TRUE),
(3, 3, '2022-07-20', TRUE),
(4, 4, '2023-01-05', TRUE),
(5, 5, '2023-04-10', TRUE);

-- Insertion des types d'évaluation
INSERT INTO type_evaluation (nom, maximum, minimum)
VALUES 
    ('Technique', 10.0, 0.0),
    ('Communication', 5.0, 0.0);

-- Insertion des évaluations basées sur les types d'évaluation
-- Insertion des evaluations basees sur les types d'evaluation
INSERT INTO Evaluation (idcandidature, idtypeEvaluation, note, dateEvaluation)
VALUES
    -- Candidature 1
    (1, 1, 8.5, '2022-02-01'), -- Evaluation Technique
    (1, 2, 4.0, '2022-02-02'), -- Evaluation Communication

    -- Candidature 2
    (2, 1, 7.5, '2022-03-01'), -- Evaluation Technique
    (2, 2, 3.8, '2022-03-02'), -- Evaluation Communication

    -- Candidature 3
    (3, 1, 9.0, '2022-08-01'), -- Evaluation Technique
    (3, 2, 4.5, '2022-08-02'), -- Evaluation Communication

    -- Candidature 4
    (4, 1, 8.0, '2023-02-01'), -- Evaluation Technique
    (4, 2, 3.9, '2023-02-02'), -- Evaluation Communication

    -- Candidature 5
    (5, 1, 8.0, '2023-05-01'), -- Evaluation Technique
    (5, 2, 4.2, '2023-05-02'); -- Evaluation Communication
-- Insérer des contrats pour les personnes embauchées
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id) VALUES
('2022-03-01', '2025-03-01', 3050000.00, 1, 1, 2, 1),
('2022-04-01', '2025-04-01', 4000000.00, 1, 2, 3, 1),
('2022-09-01', '2025-09-01', 4500000.00, 1, 3, 4, 1),
('2023-03-01', '2025-03-01', 5000000.00, 1, 4, 5, 1),
('2023-06-01', '2025-06-01', 5500000.00, 1, 5, 6, 1);

-- Insérer des notifications pour les employés
INSERT INTO notifications (idpersonne, textenotif, etat, dateheure_at) VALUES
(2, 'Votre contrat a été validé', 0, '2022-03-01 10:00:00'),
(3, 'Votre contrat a été validé', 0, '2022-04-01 10:00:00'),
(4, 'Votre contrat a été validé', 0, '2022-09-01 10:00:00'),
(5, 'Votre contrat a été validé', 0, '2023-03-01 10:00:00'),
(6, 'Votre contrat a été validé', 0, '2023-06-01 10:00:00');


-- Insertion dans la table "embauche"
INSERT INTO embauche (dateEmbauche, idcandidature)
VALUES 
    ('2024-11-20', 1);

-- Insertion dans la table "notifications"
INSERT INTO notifications (textNotif, etat, dateheure)
VALUES 
    ('Nouvelle candidature reçue', FALSE, '2024-11-14 10:00:00'),
    ('Entretien programmé pour le poste de développeur', FALSE, '2024-11-15 14:30:00');

-- Exemple de mise à jour du mot de passe pour une personne spécifique
UPDATE Personne
SET mdp = '$2y$10$UcFQhP3Syn7JhvFaGtM1YuJ95xVy6QXy0TjiCIaaN4vAVlj7Nm6j2'
WHERE id = 1; -- Remplacez 1 par l'ID de la personne


-- Ajout d'heures supplémentaires pour novembre 2024
INSERT INTO HeuresSupplementaires (employe_id, date, heures_travail)
VALUES
    (2, '2024-11-04', 5.0), -- Employé 2, premier lundi de novembre
    (2, '2024-11-07', 3.5), -- Employé 2, premier jeudi de novembre
    (3, '2024-11-10', 4.0), -- Employé 3, un dimanche
    (3, '2024-11-15', 6.0), -- Employé 3, milieu de mois
    (4, '2024-11-20', 8.0), -- Employé 4, travail intensif
    (4, '2024-11-25', 7.0), -- Employé 4, fin du mois
    (5, '2024-11-05', 2.5), -- Employé 5, début de mois
    (5, '2024-11-12', 3.0); -- Employé 5, une semaine après

-- Assurez-vous que les heures totales d'une semaine ne dépassent pas 20 heures pour chaque employé.


