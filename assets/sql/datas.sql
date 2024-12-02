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


-- Activer l'extension pgcrypto pour le hachage des mots de passe
CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- Insertion des données dans la table Personne
INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole) VALUES
-- Utilisateur avec rôle 1
('Rasolofoson Tiana', 'tiana.rasolofoson@example.com', crypt('Tiana1234!', gen_salt('bf')), '0341234567', '1990-03-21', 1), -- Tiana1234!
-- Utilisateurs avec rôle 2
('Rabe Andry', 'andry.rabe@example.com', crypt('Andry@2023', gen_salt('bf')), '0342345678', '1992-08-10', 2), -- Andry@2023
('Rakotoarisoa Faly', 'faly.rakotoarisoa@example.com', crypt('FalyPass!', gen_salt('bf')), '0343456789', '1989-12-15', 2), -- FalyPass!
('Randrianarivelo Hery', 'hery.randrianarivelo@example.com', crypt('Hery$Secure', gen_salt('bf')), '0344567890', '1985-05-22', 2), -- Hery$Secure
('Rasoarimanana Aina', 'aina.rasoarimanana@example.com', crypt('Aina@Pwd99', gen_salt('bf')), '0345678901', '1994-11-30', 2), -- Aina@Pwd99
('Raharimanana Zo', 'zo.raharimanana@example.com', crypt('ZoPwd#23', gen_salt('bf')), '0346789012', '1997-02-14', 2), -- ZoPwd#23
('Ravelomanana Miora', 'miora.ravelomanana@example.com', crypt('Miora!123', gen_salt('bf')), '0347890123', '1990-07-18', 2), -- Miora!123
('Rakotomalala Solo', 'solo.rakotomalala@example.com', crypt('SoloPwd@1', gen_salt('bf')), '0348901234', '1993-09-25', 2), -- SoloPwd@1
('Razanakoto Lova', 'lova.razanakoto@example.com', crypt('Lova@Safe1', gen_salt('bf')), '0349012345', '1991-01-12', 2), -- Lova@Safe1
('Raharinirina Noro', 'noro.raharinirina@example.com', crypt('NoroPwd2023!', gen_salt('bf')), '0340123456', '1988-04-08', 2), -- NoroPwd2023!
('Ratsimba Tahiry', 'tahiry.ratsimba@example.com', crypt('Tahiry!567', gen_salt('bf')), '0341234561', '1995-10-03', 2), -- Tahiry!567
('Ranarivelo Lalaina', 'lalaina.ranarivelo@example.com', crypt('Lalaina@42', gen_salt('bf')), '0342345671', '1987-12-29', 2), -- Lalaina@42
('Rabehasy Ny Aina', 'nyaina.rabehasy@example.com', crypt('NyAina#789', gen_salt('bf')), '0343456781', '1996-06-07', 2), -- NyAina#789
('Randriamanarivo Fetra', 'fetra.randriamanarivo@example.com', crypt('Fetra2024$', gen_salt('bf')), '0344567891', '1986-08-19', 2), -- Fetra2024$
('Ravelonjatovo Narindra', 'narindra.ravelonjatovo@example.com', crypt('Narindra#01', gen_salt('bf')), '0345678902', '1999-03-15', 2), -- Narindra#01
('Rakotomavo Fenosoa', 'fenosoa.rakotomavo@example.com', crypt('Fenosoa@123', gen_salt('bf')), '0346789013', '1984-11-28', 2), -- Fenosoa@123
('Rajaonarivony Fy', 'fy.rajaonarivony@example.com', crypt('FyPass$789', gen_salt('bf')), '0347890124', '1993-05-09', 2), -- FyPass$789
('Raharivelo Ony', 'ony.raharivelo@example.com', crypt('OnyPwd@34', gen_salt('bf')), '0348901235', '1990-09-20', 2), -- OnyPwd@34
('Rakotomanga Sitraka', 'sitraka.rakotomanga@example.com', crypt('Sitraka@567', gen_salt('bf')), '0349012346', '1985-12-01', 2), -- Sitraka@567
('Rafarasoa Neny', 'neny.rafarasoa@example.com', crypt('Neny1234!', gen_salt('bf')), '0340123457', '1998-01-18', 2); -- Neny1234!



-- Insertion des données dans la table Job
INSERT INTO Job (nom, niveau) VALUES
('Directeur Général', 'A1'), -- A1 : Poste de niveau supérieur
('Responsable RH', 'B1'),    -- B1 : Poste de gestion des ressources humaines
('Chef de Projet', 'B2'),    -- B2 : Poste de gestion de projets
('Développeur Senior', 'B2'), -- B2 : Poste de développement logiciel expérimenté
('Analyste Financier', 'B2'), -- B2 : Poste d'analyse financière
('Développeur Junior', 'C1'), -- C1 : Poste de développement débutant
('Chargé de Communication', 'C1'), -- C1 : Poste de communication
('Technicien Support', 'C1'), -- C1 : Poste de support technique
('Comptable', 'C2'),         -- C2 : Poste de comptabilité
('Assistant Administratif', 'C2'), -- C2 : Poste d'assistance administrative
('Designer UX/UI', 'B2'),    -- B2 : Poste de conception d'interface utilisateur
('Product Owner', 'B2'),     -- B2 : Poste de responsable produit
('Community Manager', 'C1'), -- C1 : Poste de gestion des réseaux sociaux
('Chef de Département', 'A2'), -- A2 : Poste de gestion de département
('Responsable Marketing', 'B1'), -- B1 : Poste de gestion marketing
('Responsable IT', 'B1'),    -- B1 : Poste de gestion informatique
('Développeur Backend', 'B2'), -- B2 : Poste de développement backend
('Développeur Frontend', 'B2'), -- B2 : Poste de développement frontend
('Chef de Cuisine', 'A2'),   -- A2 : Poste de gestion en restauration
('Responsable Commercial', 'B1'), -- B1 : Poste de gestion commerciale
('Gestionnaire de Paie', 'C2'), -- C2 : Poste de gestion des salaires
('Chargé de Clientèle', 'C1'), -- C1 : Poste de service client
('Gestionnaire de Projet', 'B2'), -- B2 : Poste de gestion de projets
('Ingénieur Logiciel', 'B2'), -- B2 : Poste d'ingénierie logicielle
('Responsable Sécurité', 'B1'), -- B1 : Poste de gestion de la sécurité
('Administrateur Systèmes', 'B2'), -- B2 : Poste d'administration système
('Responsable Logistique', 'B1'), -- B1 : Poste de gestion logistique
('Chef de Produit', 'B2');   -- B2 : Poste de gestion de produits

-- Insertion des données dans la table Offre
INSERT INTO Offre (idpersonne, idjob, dateCreation, dateFin, exigence) VALUES
-- Offre pour le poste de Directeur Général
(1, 1, '2024-12-01', '2025-12-01', 'Expérience significative en gestion d\'entreprise et leadership stratégique.'),
-- Offre pour le poste de Responsable RH
(1, 2, '2024-12-01', '2025-06-01', 'Maîtrise des processus de recrutement et gestion des talents.'),
-- Offre pour le poste de Chef de Projet
(1, 3, '2024-12-05', '2025-05-05', 'Expérience en gestion de projets agiles et coordination d\'équipes.'),
-- Offre pour le poste de Développeur Senior
(1, 4, '2024-12-07', '2025-12-07', 'Compétences en développement full-stack, avec une expertise en JavaScript et Java.'),
-- Offre pour le poste d\'Analyste Financier
(1, 5, '2024-12-10', '2025-06-10', 'Solides compétences analytiques et expérience dans les analyses financières.'),
-- Offre pour le poste de Développeur Junior
(1, 6, '2024-12-12', '2025-12-12', 'Maîtrise des bases de données SQL et des langages de programmation comme Python ou PHP.'),
-- Offre pour le poste de Chargé de Communication
(1, 7, '2024-12-14', '2025-06-14', 'Excellentes compétences en rédaction et gestion de la communication d\'entreprise.'),
-- Offre pour le poste de Technicien Support
(1, 8, '2024-12-15', '2025-12-15', 'Compétences en dépannage informatique et support client.'),
-- Offre pour le poste de Comptable
(1, 9, '2024-12-20', '2025-06-20', 'Connaissance approfondie des logiciels de comptabilité et des normes fiscales.'),
-- Offre pour le poste d\'Assistant Administratif
(1, 10, '2024-12-22', '2025-06-22', 'Bonne organisation et maîtrise des outils bureautiques.'),
-- Offre pour le poste de Designer UX/UI
(1, 11, '2024-12-25', '2025-12-25', 'Compétences en design d\'interface utilisateur et maîtrise des outils comme Figma et Adobe XD.'),
-- Offre pour le poste de Product Owner
(1, 12, '2024-12-30', '2025-06-30', 'Expérience en gestion de produit et coordination d\'équipes de développement agile.'),
-- Offre pour le poste de Community Manager
(1, 13, '2024-12-31', '2025-12-31', 'Excellente maîtrise des réseaux sociaux et compétences en gestion de la communauté en ligne.'),
-- Offre pour le poste de Chef de Département
(1, 14, '2025-01-05', '2025-12-05', 'Gestion d\'équipe et prise de décision stratégique au sein du département.'),
-- Offre pour le poste de Responsable Marketing
(1, 15, '2025-01-10', '2025-07-10', 'Solides compétences en stratégie marketing et expérience dans la gestion d\'équipes.'),
-- Offre pour le poste de Responsable IT
(1, 16, '2025-01-15', '2025-07-15', 'Compétences en gestion des infrastructures IT et des projets de transformation numérique.'),
-- Offre pour le poste de Développeur Backend
(1, 17, '2025-01-20', '2025-12-20', 'Solides compétences en développement backend avec Java, Python ou Node.js.'),
-- Offre pour le poste de Développeur Frontend
(1, 18, '2025-01-22', '2025-12-22', 'Expertise en HTML, CSS, JavaScript et frameworks modernes comme React ou Angular.'),
-- Offre pour le poste de Chef de Cuisine
(1, 19, '2025-01-25', '2025-12-25', 'Expérience en gestion de cuisine et création de menus créatifs.'),
-- Offre pour le poste de Responsable Commercial
(1, 20, '2025-01-30', '2025-07-30', 'Compétences en gestion de ventes et capacité à développer des relations clients durables.'),
-- Offre pour le poste de Gestionnaire de Paie
(1, 21, '2025-02-01', '2025-08-01', 'Connaissance des réglementations fiscales et des outils de gestion de paie.'),
-- Offre pour le poste de Chargé de Clientèle
(1, 22, '2025-02-05', '2025-08-05', 'Excellentes compétences en communication et gestion de la relation client.'),
-- Offre pour le poste de Gestionnaire de Projet
(1, 23, '2025-02-07', '2025-08-07', 'Expérience en gestion de projets et maîtrise des outils de gestion tels que Trello ou Jira.'),
-- Offre pour le poste d\'Ingénieur Logiciel
(1, 24, '2025-02-10', '2025-12-10', 'Compétences avancées en programmation et conception de logiciels.'),
-- Offre pour le poste de Responsable Sécurité
(1, 25, '2025-02-12', '2025-08-12', 'Expertise en gestion de la sécurité et des politiques de protection des données.'),
-- Offre pour le poste d\'Administrateur Systèmes
(1, 26, '2025-02-15', '2025-08-15', 'Connaissance approfondie des systèmes informatiques et des réseaux.'),
-- Offre pour le poste de Responsable Logistique
(1, 27, '2025-02-18', '2025-08-18', 'Gestion des stocks, des livraisons et des approvisionnements.'),
-- Offre pour le poste de Chef de Produit
(1, 28, '2025-02-20', '2025-08-20', 'Expérience en gestion de produit, de la conception à la mise en marché.'); -- Chef de Produit

-- Insertion des données dans la table cv
INSERT INTO cv (idpersonne, competence, note_competence, experience, note_experience, education, note_education, remarque, chemin) VALUES
-- CV de la personne 1 (Directeur Général)
(2, 'Leadership stratégique, gestion d\'entreprise, prise de décision', 9, 'Expérience de 10 ans en direction générale', 8, 'MBA en gestion d\'entreprise', 9, 'Excellent sens de la gestion et du développement des affaires', 'chemin/vers/cv1.pdf'),
-- CV de la personne 2 (Responsable RH)
(1, 'Recrutement, gestion des talents, relations sociales', 8, '5 ans d\'expérience dans les ressources humaines', 7, 'Master en gestion des ressources humaines', 8, 'Bonne capacité à gérer des équipes et à recruter efficacement', 'chemin/vers/cv2.pdf'),
-- CV de la personne 3 (Chef de Projet)
(3, 'Gestion de projets agiles, gestion d\'équipes', 7, '3 ans d\'expérience en gestion de projets agiles', 6, 'Master en management de projet', 7, 'Capacité à gérer des équipes diverses et à respecter les délais', 'chemin/vers/cv3.pdf'),
-- CV de la personne 4 (Développeur Senior)
(4, 'Développement full-stack, JavaScript, Java, PHP', 9, '5 ans d\'expérience en développement logiciel', 8, 'Licence en informatique', 9, 'Excellentes compétences techniques en développement backend et frontend', 'chemin/vers/cv4.pdf'),
-- CV de la personne 5 (Analyste Financier)
(5, 'Analyse financière, gestion de budgets, reporting', 8, '4 ans d\'expérience en finance et analyse de données', 7, 'Master en finance', 8, 'Bonne connaissance des outils financiers et gestion de la rentabilité', 'chemin/vers/cv5.pdf'),
-- CV de la personne 6 (Développeur Junior)
(6, 'Programmation Python, SQL, JavaScript', 6, '1 an d\'expérience en développement logiciel', 5, 'BTS en informatique', 6, 'Capacité à apprendre rapidement et à s\'adapter aux nouvelles technologies', 'chemin/vers/cv6.pdf'),
-- CV de la personne 7 (Chargé de Communication)
(7, 'Rédaction, gestion de la communication interne et externe', 7, '2 ans d\'expérience en communication', 6, 'Licence en communication', 7, 'Compétences en gestion de contenu et relations publiques', 'chemin/vers/cv7.pdf'),
-- CV de la personne 8 (Technicien Support)
(8, 'Support technique, dépannage, gestion des tickets', 7, '3 ans d\'expérience en support informatique', 7, 'BTS en systèmes informatiques', 8, 'Bonnes compétences techniques et relationnelles avec les utilisateurs', 'chemin/vers/cv8.pdf'),
-- CV de la personne 9 (Comptable)
(9, 'Comptabilité, gestion des finances, logiciels de comptabilité', 8, '5 ans d\'expérience en comptabilité', 8, 'Master en comptabilité et finance', 9, 'Excellente gestion des finances et des rapports financiers', 'chemin/vers/cv9.pdf'),
-- CV de la personne 10 (Assistant Administratif)
(10, 'Organisation administrative, gestion des agendas, support de direction', 7, '3 ans d\'expérience en administration', 7, 'BTS en gestion administrative', 8, 'Excellente organisation et capacité à gérer plusieurs tâches simultanément', 'chemin/vers/cv10.pdf'),
-- CV de la personne 11 (Designer UX/UI)
(11, 'Design d\'interfaces, expérience utilisateur, logiciels de design', 8, '4 ans d\'expérience en design', 8, 'Licence en design graphique', 9, 'Créativité et maîtrise des outils UX/UI tels que Figma et Adobe XD', 'chemin/vers/cv11.pdf'),
-- CV de la personne 12 (Product Owner)
(12, 'Gestion de produit, méthodologie agile, gestion de projets', 9, '5 ans d\'expérience en gestion de produits', 8, 'Master en gestion de produit', 9, 'Compétences en gestion de produit de la conception à la mise sur le marché', 'chemin/vers/cv12.pdf'),
-- CV de la personne 13 (Community Manager)
(13, 'Gestion des réseaux sociaux, marketing digital, stratégie de contenu', 7, '2 ans d\'expérience en gestion de communautés', 6, 'Licence en marketing', 7, 'Compétences en gestion de communauté et stratégie digitale', 'chemin/vers/cv13.pdf'),
-- CV de la personne 14 (Chef de Département)
(14, 'Gestion d\'équipe, prise de décision stratégique, management', 8, '6 ans d\'expérience en gestion d\'équipe', 7, 'Master en management', 8, 'Leadership et capacité à prendre des décisions stratégiques', 'chemin/vers/cv14.pdf'),
-- CV de la personne 15 (Responsable Marketing)
(15, 'Stratégie marketing, gestion de campagnes, analyse de données', 8, '5 ans d\'expérience en marketing', 8, 'Master en marketing', 9, 'Excellentes compétences en stratégie marketing et gestion de campagnes', 'chemin/vers/cv15.pdf');


-- Insertion des données dans la table Candidature
INSERT INTO Candidature (idcv, idOffre, datePostule, etat) VALUES
-- Candidature pour le poste de Responsable RH (idpersonne 2, idrole 1)
(2, 2, '2024-12-01', TRUE), -- La personne avec idrole=1 postule pour le poste de Responsable RH
-- Candidature pour le poste de Chef de Projet (idpersonne 3)
(3, 3, '2024-12-05', FALSE),
-- Candidature pour le poste de Développeur Senior (idpersonne 4)
(4, 4, '2024-12-07', FALSE),
-- Candidature pour le poste d'Analyste Financier (idpersonne 5)
(5, 5, '2024-12-10', FALSE),
-- Candidature pour le poste de Développeur Junior (idpersonne 6)
(6, 6, '2024-12-12', FALSE),
-- Candidature pour le poste de Chargé de Communication (idpersonne 7)
(7, 7, '2024-12-14', FALSE),
-- Candidature pour le poste de Technicien Support (idpersonne 8)
(8, 8, '2024-12-15', FALSE),
-- Candidature pour le poste de Comptable (idpersonne 9)
(9, 9, '2024-12-20', FALSE),
-- Candidature pour le poste d'Assistant Administratif (idpersonne 10)
(10, 10, '2024-12-22', FALSE),
-- Candidature pour le poste de Designer UX/UI (idpersonne 11)
(11, 11, '2024-12-25', FALSE),
-- Candidature pour le poste de Product Owner (idpersonne 12)
(12, 12, '2024-12-30', FALSE),
-- Candidature pour le poste de Community Manager (idpersonne 13)
(13, 13, '2024-12-31', TRUE),
-- Candidature pour le poste de Chef de Département (idpersonne 14)
(14, 14, '2025-01-05', TRUE),
-- Candidature pour le poste de Responsable Marketing (idpersonne 15)
(15, 15, '2025-01-10', TRUE);



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

-- Insertion des évaluations dans la table Evaluation (uniquement pour les 6 premiers candidats, sauf le Responsable RH)
INSERT INTO Evaluation (idcandidature, idtypeEvaluation, note, dateEvaluation) VALUES
-- Candidature 2 (Chef de Projet) : Evaluation technique
(2, 1, ROUND( (RANDOM() * (10.0 - 4.0) + 4.0), 2), '2024-12-05'), -- Note aléatoire entre 4 et 10
-- Candidature 2 (Chef de Projet) : Evaluation communication
(2, 2, ROUND( (RANDOM() * (5.0 - 3.0) + 3.0), 2), '2024-12-05'), -- Note aléatoire entre 3 et 5
-- Candidature 3 (Développeur Senior) : Evaluation technique
(3, 1, ROUND( (RANDOM() * (10.0 - 7.0) + 7.0), 2), '2024-12-07'), -- Note aléatoire entre 7 et 10
-- Candidature 3 (Développeur Senior) : Evaluation communication
(3, 2, ROUND( (RANDOM() * (5.0 - 2.0) + 2.0), 2), '2024-12-07'), -- Note aléatoire entre 2 et 5
-- Candidature 4 (Analyste Financier) : Evaluation technique
(4, 1, ROUND( (RANDOM() * (10.0 - 5.0) + 5.0), 2), '2024-12-10'), -- Note aléatoire entre 5 et 10
-- Candidature 4 (Analyste Financier) : Evaluation communication
(4, 2, ROUND( (RANDOM() * (5.0 - 3.5) + 3.5), 2), '2024-12-10'), -- Note aléatoire entre 3.5 et 5
-- Candidature 5 (Développeur Junior) : Evaluation technique
(5, 1, ROUND( (RANDOM() * (10.0 - 6.0) + 6.0), 2), '2024-12-12'), -- Note aléatoire entre 6 et 10
-- Candidature 5 (Développeur Junior) : Evaluation communication
(5, 2, ROUND( (RANDOM() * (5.0 - 2.0) + 2.0), 2), '2024-12-12'), -- Note aléatoire entre 2 et 5
-- Candidature 6 (Chargé de Communication) : Evaluation technique
(6, 1, ROUND( (RANDOM() * (10.0 - 3.0) + 3.0), 2), '2024-12-14'), -- Note aléatoire entre 3 et 10
-- Candidature 6 (Chargé de Communication) : Evaluation communication
(6, 2, ROUND( (RANDOM() * (5.0 - 3.0) + 3.0), 2), '2024-12-14'), -- Note aléatoire entre 3 et 5
-- Candidature 7 (Technicien Support) : Evaluation technique
(7, 1, ROUND( (RANDOM() * (10.0 - 6.0) + 6.0), 2), '2024-12-15'), -- Note aléatoire entre 6 et 10
-- Candidature 7 (Technicien Support) : Evaluation communication
(7, 2, ROUND( (RANDOM() * (5.0 - 3.0) + 3.0), 2), '2024-12-15'), -- Note aléatoire entre 3 et 5
-- Candidature 8 (Comptable) : Evaluation technique
(8, 1, ROUND( (RANDOM() * (10.0 - 7.0) + 7.0), 2), '2024-12-20'), -- Note aléatoire entre 7 et 10
-- Candidature 8 (Comptable) : Evaluation communication
(8, 2, ROUND( (RANDOM() * (5.0 - 4.0) + 4.0), 2), '2024-12-20'), -- Note aléatoire entre 4 et 5
-- Candidature 9 (Assistant Administratif) : Evaluation technique
(9, 1, ROUND( (RANDOM() * (10.0 - 6.0) + 6.0), 2), '2024-12-22'), -- Note aléatoire entre 6 et 10
-- Candidature 9 (Assistant Administratif) : Evaluation communication
(9, 2, ROUND( (RANDOM() * (5.0 - 3.5) + 3.5), 2), '2024-12-22'), -- Note aléatoire entre 3.5 et 5
-- Candidature 10 (Designer UX/UI) : Evaluation technique
(10, 1, ROUND( (RANDOM() * (10.0 - 5.0) + 5.0), 2), '2024-12-25'), -- Note aléatoire entre 5 et 10
-- Candidature 10 (Designer UX/UI) : Evaluation communication
(10, 2, ROUND( (RANDOM() * (5.0 - 4.0) + 4.0), 2), '2024-12-25'), -- Note aléatoire entre 4 et 5
-- Candidature 11 (Product Owner) : Evaluation technique
(11, 1, ROUND( (RANDOM() * (10.0 - 8.0) + 8.0), 2), '2024-12-30'), -- Note aléatoire entre 8 et 10
-- Candidature 11 (Product Owner) : Evaluation communication
(11, 2, ROUND( (RANDOM() * (5.0 - 3.5) + 3.5), 2), '2024-12-30'); -- Note aléatoire entre 3.5 et 5

-- Insérer les valeurs initiales dans les tables de référence
INSERT INTO Statut (label) VALUES ('Actif'), ('Resilié');
INSERT INTO Statut_Preavis (label) VALUES ('En cours'), ('Non respecter'), ('Terminer');
INSERT INTO Statut_Paiement (label) VALUES ('En attente'), ('Régle');
INSERT INTO Type_Rupture (label) VALUES ('Licenciement'), ('Demission');


INSERT INTO TypesJours (type_label, description)
VALUES 
    ('dimanche', 'Jour travaillé le dimanche'),
    ('ferie', 'Jour férié officiel'),
    ('autre', 'Autres jours spéciaux non définis');
    

-- Insertion des contrats pour les candidats ayant réussi leurs évaluations avec des salaires réalistes en Arriary (MGA)

-- Contrat pour le Chef de Projet (Candidature 2)
-- Salaire pour un Chef de Projet : 4500.00 EUR * 4500 MGA = 20,250,000 MGA
-- Niveau : A1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2024-12-15', '2025-12-15', 20250000.00, 1, 2, 2, 1, 'A1');

-- Contrat pour le Développeur Senior (Candidature 3)
-- Salaire pour un Développeur Senior : 5500.00 EUR * 4500 MGA = 24,750,000 MGA
-- Niveau : B1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2024-12-20', '2025-12-20', 24750000.00, 1, 3, 3, 2, 'B1');

-- Contrat pour l'Analyste Financier (Candidature 4)
-- Salaire pour un Analyste Financier : 3500.00 EUR * 4500 MGA = 15,750,000 MGA
-- Niveau : B2
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2024-12-25', '2025-12-25', 15750000.00, 1, 4, 4, 2, 'B2');

-- Contrat pour le Développeur Junior (Candidature 5)
-- Salaire pour un Développeur Junior : 2800.00 EUR * 4500 MGA = 12,600,000 MGA
-- Niveau : C1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-01-10', '2026-01-10', 12600000.00, 1, 5, 5, 2, 'C1');

-- Contrat pour le Chargé de Communication (Candidature 6)
-- Salaire pour un Chargé de Communication : 3000.00 EUR * 4500 MGA = 13,500,000 MGA
-- Niveau : B1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-01-15', '2026-01-15', 13500000.00, 1, 6, 6, 2, 'B1');

-- Contrat pour le Technicien Support (Candidature 7)
-- Salaire pour un Technicien Support : 2500.00 EUR * 4500 MGA = 11,250,000 MGA
-- Niveau : C2
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-01-20', '2026-01-20', 11250000.00, 1, 7, 7, 2, 'C2');

-- Contrat pour le Comptable (Candidature 8)
-- Salaire pour un Comptable : 3200.00 EUR * 4500 MGA = 14,400,000 MGA
-- Niveau : B2
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-01-25', '2026-01-25', 14400000.00, 1, 8, 8, 2, 'B2');

-- Contrat pour l'Assistant Administratif (Candidature 9)
-- Salaire pour un Assistant Administratif : 2200.00 EUR * 4500 MGA = 9,900,000 MGA
-- Niveau : C1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-02-01', '2026-02-01', 9900000.00, 1, 9, 9, 2, 'C1');

-- Contrat pour le Designer UX/UI (Candidature 10)
-- Salaire pour un Designer UX/UI : 3800.00 EUR * 4500 MGA = 17,100,000 MGA
-- Niveau : B1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-02-05', '2026-02-05', 17100000.00, 1, 10, 10, 2, 'B1');

-- Contrat pour le Product Owner (Candidature 11)
-- Salaire pour un Product Owner : 4800.00 EUR * 4500 MGA = 21,600,000 MGA
-- Niveau : A1
INSERT INTO Contrat (date_debut, date_fin, salaire, statut_id, candidature_id, employe_id, employeur_id, niveau)
VALUES ('2025-02-10', '2026-02-10', 21600000.00, 1, 11, 11, 2, 'A1');



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


