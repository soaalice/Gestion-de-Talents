<?php

include "header.php";
require_once 'inc/m_learning.php';

try {
    // Récupérer les offres disponibles
    $id = $_GET['id'] ?? null;
    $offers = $user->getOffers();

    // if (!$id) {
    //     throw new Exception("ID de l'offre manquant !");
    // }

    // Récupérer les offres disponibles
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $offerId = $_POST['offer_id'];
        $applicationDate = $_POST['application_date'];
        $personId = $_SESSION['user_id']; // L'ID de l'utilisateur connecté est supposé être dans la session

        // if ($user->createApplication($offerId, $applicationDate, $personId)) {
        //     echo "<div class='alert alert-success text-center'>Application successfully submitted!</div>";
        // } else {
        //     echo "<div class='alert alert-danger text-center'>Failed to submit application.</div>";
        // }

        // $offers = $user->getOffreById($id);
        // if (empty($offers)) {
        //     throw new Exception("Aucune offre trouvée pour l'ID spécifié !");
        // }

        // $test = $user->isApplying($_SESSION['user_id'], $id);

        // echo "Offre trouvée : <pre>" . print_r($offers, true) . "</pre>"; // Debug ici

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
            // Vérification de la session utilisateur
            $personcv = $_SESSION['user_id'] ?? null;
            if (!$personcv) {
                throw new Exception("L'utilisateur connecté n'a pas de CV enregistré !");
            }

            // $offerId = $id;
            $exigence = $offers[0]['exigence'] ?? '';
            if (empty($exigence)) {
                throw new Exception("L'offre n'a pas d'exigence définie !");
            }

            // Transformer le CV en texte
            $cvtext = extractTextFromPdf($_FILES['pdfFile']);
            // var_dump($cvtext);
            if (empty($cvtext['contenu']) || empty($cvtext['chemin'])) {
                throw new Exception("Le fichier PDF est invalide ou vide !");
            }

            // Analyser le CV par rapport à l'exigence
            $resultatAnalyse = analyzeCV($cvtext['contenu'], $exigence);

            // Sauvegarder le CV et récupérer son ID
            $idCv = $user->saveCV(
                $personcv,
                $resultatAnalyse['education']['content'], $resultatAnalyse['education']['note'],
                $resultatAnalyse['experience']['content'], $resultatAnalyse['experience']['note'],
                $resultatAnalyse['competence']['content'], $resultatAnalyse['competence']['note'],
                $resultatAnalyse['remarque'], $cvtext['chemin']
            );

            if (!$idCv) {
                throw new Exception("Échec de la sauvegarde du CV !");
            }

            // Sauvegarder la candidature
            $applicationDate = $_POST['application_date'] ?? null;
            if (!$applicationDate) {
                throw new Exception("La date de candidature est manquante !");
            }

            // Exemple de sauvegarde (décommenter si nécessaire)
            if ($user->createApplication($offerId, $applicationDate, $idCv)) {
                echo "<p>Application successfully submitted!</p>";
                header('location:index.php?page=application');
                exit;
            } else {
                throw new Exception("Échec de l'envoi de la candidature !");
            }
            
        }
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
}

?>



<!-- <h2>Apply for an Offer</h2>
<form method="post" action="index.php?page=applicationForm&id=<?= $id ?>"  enctype="multipart/form-data">
  
 <?php // if (count($test) == 0 ) { ?>
    <label>Date of Application:</label><br>
    <input type="date" name="application_date" required><br><br>
    <label for="pdfFile">Choisir un fichier PDF :</label><br>
    <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" required><br><br>
    <input type="submit" value="Apply">
    <?php  //}else{ ?>
        <p>You already applied .</p>
        
    <?php //} ?>
</form> -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg p-4" style="border-radius: 15px; background-color: #eaf4f0; border: 1px solid #6fa37d;">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4" style="color: #3a6a40;">Postuler à une offre</h2>
                    <form method="post" action="index.php?page=applicationForm&id=<?= $id ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="offer_id" style="color: #3a6a40;">Offre :</label>
                            <select name="offer_id" id="offer_id" class="form-control" required>
                                <?php foreach ($offers as $offer): ?>
                                    <option
                                        <?php if($id): if($id == $offerId) echo "selected"; endif ?>
                                        value="<?= htmlspecialchars($offer['id']) ?>">
                                        <?= htmlspecialchars($offer['job_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="application_date" style="color: #3a6a40;">Date de la candidature :</label>
                            <input type="date" name="application_date" id="application_date" class="form-control" required>
                        </div>
                      <div class = "form-group mt-3">
                        <label for="pdfFile">Choisir un fichier PDF :</label>
                        <input type="file" id="pdfFile" name="pdfFile" accept=".pdf"  class="form-control" required>
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

