<?php
// Récupération des jobs pour les afficher dans le formulaire
$jobs = $user->getJobs();
include 'header.php';

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
?>

<div class="container mt-5 mb-5 pb-5">
    <div class="m-3 mb-4">
        <h2 class="text-center" style="color: #3a6a40;">Create an Offer</h2>
    </div>


    

    <form method="post" action="index.php?page=offerForm" class="shadow-lg p-4" style="background-color: #f1f8f3; border-radius: 8px;">
        <div class="mb-3">
            <label for="job_id" class="form-label" style="color: black;">Select Job</label>
            <select name="job_id" id="job_id" class="form-select" required >
                <?php foreach ($jobs as $job): ?>
                    <option value="<?= htmlspecialchars($job['id']) ?>">
                        <?= htmlspecialchars($job['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="id_exigence" class="form-label" style="color: black;">Exigence </label>
            <textarea type="text" name="exigence" class="ps-2 form-area form-control" id="id_exigence" required></textarea> 
        </div>

        <div class="mb-3">
            <label for="date_offer" class="form-label" style="color: black;">Date of Offer</label>
            <input type="date" name="date_offer" id="date_offer" class="form-control" required >
        </div>

        <div class="mb-3">
            <label class="form-label" for="date_lim"  style="color: black;">Date Limit of Offer</label><br>
            <input type="date" name="date_limit" id="date_lim" class="form-control"  required><br><br>
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
        /* background-color: #eaf4e0; Fond doux vert clair
        border-color: #d0e0d6; Bordure douce */
        color: #3a6a40; /* Texte sombre et naturel */
    }

    input[type="number"]:focus, input[type="date"]:focus, .form-select:focus, .form-area:focus {
        border-color: #6d9e4e; /* Bordure plus foncée lors du focus */
        outline: none;
        box-shadow: 0 0 5px rgba(56, 189, 94, 0.5); /* Ombre verte douce */
    }
    textarea {
        /* width: 100%; */
        min-height: 2em;
    }
</style>

