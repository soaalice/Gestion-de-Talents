<?php
// Vérification que l'utilisateur est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$applicationId = isset($_GET['applicationId']) ? $_GET['applicationId'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];

    // Insertion de la note dans la table Evaluation
    $stmt = $db->getConnection()->prepare("
        INSERT INTO Evaluation (note, idcandidature, idtypeevaluation, dateevaluation)
        VALUES (?, ?, 1,now())
    ");
    $stmt->execute([$note, $applicationId]);

    // Redirection vers le tableau des candidatures
    header('Location: index.php?page=recruiterDashboard');
    exit;
}
?>

<form method="POST">
    <label for="note">Note du Test Écrit :</label>
    <input type="number" name="note" step="0.01" min="0" max="20" required>
    <button type="submit">Soumettre</button>
</form>
