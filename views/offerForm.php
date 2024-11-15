<?php
// Récupération des jobs pour les afficher dans le formulaire
$jobs = $user->getJobs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = $_POST['job_id'];
    $exigence = $_POST['exigence'];
    $datelimit = $_POST['date_limit'];
    $dateOffer = $_POST['date_offer'];
    $personId = $_SESSION['user_id']; // Suppose que l'ID de l'utilisateur connecté est stocké en session

    if ($user->createOffer($jobId, $exigence,$datelimit, $dateOffer, $personId)) {
        echo "<p>Offer successfully created!</p>";
    } else {
        echo "<p>Failed to create offer.</p>";
    }
}
?>

<h2>Create an Offer</h2>
<form method="post" action="index.php?page=offerForm">
    <label>Job:</label><br>
    <select name="job_id" required>
        <?php foreach ($jobs as $job): ?>
            <option value="<?= htmlspecialchars($job['id']) ?>"><?= htmlspecialchars($job['nom']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Exigence:</label><br>
    <input type="text" name="exigence" required><br><br>

    <label>Date of Offer:</label><br>
    <input type="date" name="date_offer" required><br><br>

    <label>Date Limit of Offer:</label><br>
    <input type="date" name="date_limit" required><br><br>

    <input type="submit" value="Create Offer">
</form>