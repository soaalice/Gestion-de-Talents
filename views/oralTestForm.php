<?php
// Vérification que l'utilisateur est authentifié et est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$applicationId = isset($_GET['applicationId']) ? $_GET['applicationId'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];

    // Vérifier si la note a déjà été attribuée pour ce test oral
    $stmt = $db->getConnection()->prepare("
        SELECT id FROM Evaluation 
        WHERE idcandidature = ? AND idtypeevaluation = 2
    ");
    $stmt->execute([$applicationId]);
    $existingNote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingNote) {
        // Si une note existe déjà, mettre à jour la note
        $updateStmt = $db->getConnection()->prepare("
            UPDATE Evaluation 
            SET note = ? 
            WHERE idcandidature = ? AND idtypeevaluation = 2
        ");
        $updateStmt->execute([$note, $applicationId]);
    } else {
        // Sinon, insérer une nouvelle évaluation pour ce test oral
        $insertStmt = $db->getConnection()->prepare("
            INSERT INTO Evaluation (note, idcandidature, idtypeevaluation, dateevaluation)
        VALUES (?, ?, 2,now())
        ");
        $insertStmt->execute([$note, $applicationId]);
    }

    // Redirection vers le tableau de bord du recruteur après soumission
    header('Location: index.php?page=recruiterDashboard');
    exit;
}
include 'header.php';
?>

<h2>Évaluation du Test Oral</h2>

<!-- Formulaire pour saisir la note du test oral -->
<form method="POST">
    <label for="note">Note du Test Oral :</label>
    <input type="number" name="note" step="0.01" min="0" max="20" required>
    <button type="submit">Soumettre</button>
</form>