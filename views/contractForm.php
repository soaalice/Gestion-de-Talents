<?php
$idcandidat = $_GET['idcandidat'];
$idcandidature = $_GET['idcandidature'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $salaire = $_POST['salaire'];
    $personId = $_SESSION['user_id']; 


    if ($user->createContract($date_debut, $date_fin,$salaire,$candidature, $idcandidat, $personId)) {
        echo "<div class='alert alert-success text-center mt-4'>Offer successfully created!</div>";
        header('location:index.php?page=recruiterDashboard');
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Failed to create offer. Please try again.</div>";
    }
}
include('header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Contrat</title>
</head>
<body>
    <h1>Créer un Contrat</h1>
    <form method="POST" action="">
        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" required><br><br>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin"><br><br>
        
        <label for="date_fin">Salaire :</label>
        <input type="number" id="salaire" name="salaire"><br><br>

        <button type="submit">Créer le Contrat</button>
    </form>
</body>
</html>