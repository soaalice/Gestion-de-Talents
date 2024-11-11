<?php
// Récupérer les offres disponibles
$offers = $user->getOffers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offerId = $_POST['offer_id'];
    $applicationDate = $_POST['application_date'];
    $personId = $_SESSION['user_id']; // L'ID de l'utilisateur connecté est supposé être dans la session

    if ($user->createApplication($offerId, $applicationDate, $personId)) {
        echo "<p>Application successfully submitted!</p>";
    } else {
        echo "<p>Failed to submit application.</p>";
    }
}
?>

<h2>Apply for an Offer</h2>
<form method="post" action="index.php?page=applicationForm">
    <label>Offer:</label><br>
    <select name="offer_id" required>
        <?php foreach ($offers as $offer): ?>
            <option value="<?= htmlspecialchars($offer['id']) ?>">
                Job Title: <?= htmlspecialchars($offer['job_name']) ?> -
                Salary: <?= htmlspecialchars($offer['salaire']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Date of Application:</label><br>
    <input type="date" name="application_date" required><br><br>

    <input type="submit" value="Apply">
</form>