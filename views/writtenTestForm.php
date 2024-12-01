<?php
// Vérification que l'utilisateur est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$applicationId = isset($_GET['applicationId']) ? $_GET['applicationId'] : null;

$idcandidat = isset($_GET['idcandidat']) ? $_GET['idcandidat'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];

    // Insertion de la note dans la table Evaluation
    $stmt = $db->getConnection()->prepare("
        INSERT INTO Evaluation (note, idcandidature, idtypeevaluation, dateevaluation)
        VALUES (?, ?, 1,now())
    ");
    $stmt->execute([$note, $applicationId]);
    $user->insertNotifs("Votre note ecrite a ete determinee , veuillez verifier.",$idcandidat);

    // Redirection vers le tableau des candidatures
    header('Location: index.php?page=recruiterDashboard');
    exit;
}
include 'header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-3" style="color: #3a6a40;">Evaluation du Test Écrit</h2>
    <div class="row">
        <div class="col-4 offset-4">
            <form method="POST" class="shadow-lg p-4" style="background-color: #e6f4e6; border-radius: 8px;">
                <div class="form-group mb-3">
                    <label for="note" style="color: #2b7a2b;">Note du Test Écrit :</label>
                    <input type="number" name="note" step="0.01" min="0" max="20" required class="form-control" style="background-color: #f9fff9; border: 1px solid #a8d5a2; color: #3a6a40;">
                </div>
                <button type="submit" class="btn btn-success w-100">Soumettre</button>
            </form>
        </div>
    </div>
</div>

<!-- CSS pour le thème nature et écologie -->
<style>
    .btn-outline-success {
        color: #3a6a40;
        border-color: #3a6a40;
        transition: all 0.3s ease;
    }
    .btn-outline-success:hover {
        background-color: #3a6a40;
        color: #fff;
    }
    .form-control {
        padding: 10px;
        color: #3a6a40;
    }
</style>
