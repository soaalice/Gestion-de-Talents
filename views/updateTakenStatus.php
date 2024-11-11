<?php
// Inclure la connexion à la base de données et la classe User
require_once 'database.php';
require_once 'user.php';

// Vérifier si l'utilisateur est authentifié et est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'recruteur') {
    header('Location: index.php?page=login');
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['candidature_id'])) {
    $candidatureId = (int) $_POST['candidature_id'];

    // Mettre à jour la colonne 'isTaken' de la candidature dans la base de données
    $stmt = $db->getConnection()->prepare("
        UPDATE Candidature
        SET isTaken = true
        WHERE id = ?
    ");
    $stmt->execute([$candidatureId]);

    // Rediriger vers la page des candidatures après la mise à jour
    header('Location: index.php?page=recruiterApplications');
    exit;
} else {
    echo "Invalid request.";
}
?>