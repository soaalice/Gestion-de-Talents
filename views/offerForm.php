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
        echo "<div class='alert alert-success text-center mt-4'>Offer successfully created!</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Failed to create offer. Please try again.</div>";
    }
}
include 'header.php';
?>

<div class="container mt-5 mb-5 pb-5">
    <div class="m-3 mb-4">
        <h2 class="text-center" style="color: #3a6a40;">Create an Offer</h2>
    </div>


    

    <form method="post" action="index.php?page=offerForm" class="shadow-lg p-4" style="background-color: #f1f8f3; border-radius: 8px;">
        <div class="mb-3">
            <label for="job_id" class="form-label" style="color: #2b7a2b;">Select Job</label>
            <select name="job_id" id="job_id" class="form-select" required style="background-color: #eaf4e0; border-color: #d0e0d6; color: #3a6a40;">
                <?php foreach ($jobs as $job): ?>
                    <option value="<?= htmlspecialchars($job['id']) ?>">
                        <?= htmlspecialchars($job['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Exigence:</label><br>
            <textarea type="text" name="exigence" required></textarea><br><br>
        </div>

        <div class="mb-3">
            <label for="date_offer" class="form-label" style="color: #2b7a2b;">Date of Offer</label>
            <input type="date" name="date_offer" id="date_offer" class="form-control" required style="background-color: #eaf4e0; border-color: #d0e0d6; color: #3a6a40;">
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #2b7a2b;">Date Limit of Offer:</label><br>
            <input type="date" name="date_limit" class="form-control" ="background-color: #eaf4e0; border-color: #d0e0d6; color: #3a6a40;" required><br><br>
        </div>

        <div class="text-center">
            <input type="submit" value="Create Offer" class="btn btn-warning btn-lg highlight-btn">
        </div>
    </form>
</div>

<!-- CSS pour ajouter du style aux boutons et aux éléments de formulaire -->
<style>
    .highlight-btn {
        transition: all 0.3s ease-in-out;
    }
    .highlight-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(56, 189, 94, 0.5); /* Ombre verte légère */
        border-color: #3a6a40; /* Bordure légèrement plus sombre */
        background-color: #f1f8f3; /* Fond léger au survol */
    }

    /* Style pour les éléments input/select */
    input[type="number"], input[type="date"], .form-select {
        background-color: #eaf4e0; /* Fond doux vert clair */
        border-color: #d0e0d6; /* Bordure douce */
        color: #3a6a40; /* Texte sombre et naturel */
    }

    input[type="number"]:focus, input[type="date"]:focus, .form-select:focus {
        border-color: #6d9e4e; /* Bordure plus foncée lors du focus */
        outline: none;
        box-shadow: 0 0 5px rgba(56, 189, 94, 0.5); /* Ombre verte douce */
    }
</style>

