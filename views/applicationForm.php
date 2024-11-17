<?php
// Récupérer les offres disponibles
$offers = $user->getOffers();
include "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offerId = $_POST['offer_id'];
    $applicationDate = $_POST['application_date'];
    $personId = $_SESSION['user_id']; // L'ID de l'utilisateur connecté est supposé être dans la session

    if ($user->createApplication($offerId, $applicationDate, $personId)) {
        echo "<div class='alert alert-success text-center'>Application successfully submitted!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Failed to submit application.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg p-4" style="border-radius: 15px; background-color: #eaf4f0; border: 1px solid #6fa37d;">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4" style="color: #3a6a40;">Postuler à une offre</h2>
                    <form method="post" action="index.php?page=applicationForm">
                        <div class="form-group">
                            <label for="offer_id" style="color: #3a6a40;">Offre :</label>
                            <select name="offer_id" id="offer_id" class="form-control" required>
                                <?php foreach ($offers as $offer): ?>
                                    <option value="<?= htmlspecialchars($offer['id']) ?>">
                                        <?= htmlspecialchars($offer['job_name']) ?> -
                                        Salaire : <?= htmlspecialchars($offer['salaire']) ?> MGA
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="application_date" style="color: #3a6a40;">Date de la candidature :</label>
                            <input type="date" name="application_date" id="application_date" class="form-control" required>
                        </div>

                        <div class="form-group mt-4">
                            <input type="submit" value="Postuler" class="btn btn-success btn-block" style="background-color: #6fa37d; border: none; border-radius: 10px;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Alertes personnalisées */
    .alert {
        font-size: 16px;
        font-weight: bold;
    }

    /* Titre de la carte */
    .card-title {
        font-size: 24px;
        font-weight: 500;
        color: #3a6a40; /* Couleur naturelle verte */
    }

    /* Espacement des éléments du formulaire */
    .form-group {
        margin-bottom: 20px;
    }
</style>
