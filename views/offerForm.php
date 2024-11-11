<?php
// Récupération des jobs pour les afficher dans le formulaire
$jobs = $user->getJobs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = $_POST['job_id'];
    $salary = $_POST['salary'];
    $dateOffer = $_POST['date_offer'];
    $personId = $_SESSION['user_id']; // Suppose que l'ID de l'utilisateur connecté est stocké en session

    if ($user->createOffer($jobId, $salary, $dateOffer, $personId)) {
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

    <label>Salary:</label><br>
    <input type="number" name="salary" step="0.01" required><br><br>

    <label>Date of Offer:</label><br>
    <input type="date" name="date_offer" required><br><br>

    <input type="submit" value="Create Offer">
</form>