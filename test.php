<!-- <?php
// Connexion à la base de données
// $dsn = 'pgsql:host=localhost;dbname=talents';
// $username = 'postgres';
// $password = '2547';

// try {
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Rôles
//     $roles = [
//         'admin' => 1,  // ID du rôle admin
//         'client' => 2  // ID du rôle client
//     ];

//     // Liste des noms pour générer les données
//     $noms = [
//         'Rabe Rakoto', 'Razafy Rasoarimanana', 'Andry Ratsimba', 'Faly Rakotomalala',
//         'Tiana Randrianarisoa', 'Hery Raharimanana', 'Fanja Rasoanirina', 'Miora Rabetokotany',
//         'Eric Rabeson', 'Hanitra Ralambomanana', 'Lala Randriamampionona', 'Haja Rafanomezantsoa',
//         'Voahirana Razafindrakoto', 'Tojo Ramanandafy', 'Arisoa Ravelonarivo', 'Solohery Rakotovao',
//         'Vola Rakotonirina', 'Mahery Rasoamanana', 'Mamy Ramaroson'
//     ];

//     // Insérer les données
//     $password = '1234';
//     $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

//     foreach ($noms as $index => $nom) {
//         $email = 'client' . ($index + 1) . '@example.com';
//         $phone = '034' . str_pad($index + 1, 8, '0', STR_PAD_LEFT);
//         $datenaissance = '1990-01-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
//         $idrole = $roles['client'];

//         // Insérer dans la table Personne
//         $stmt = $pdo->prepare("
//             INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole) 
//             VALUES (:nom, :email, :mdp, :phone, :datenaissance, :idrole)
//         ");
//         $stmt->execute([
//             'nom' => $nom,
//             'email' => $email,
//             'mdp' => $hashedPassword,
//             'phone' => $phone,
//             'datenaissance' => $datenaissance,
//             'idrole' => $idrole
//         ]);

//         echo "Utilisateur ajouté : $nom avec email $email\n";
//     }

//     echo "Tous les utilisateurs ont été insérés avec succès.";

// } catch (PDOException $e) {
//     echo "Erreur : " . $e->getMessage();
// }
?> -->