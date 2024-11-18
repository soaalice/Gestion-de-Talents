<?php

require_once 'inc/func.php';

try {
    // Récupérer les offres disponibles
    $id = $_GET['id'] ?? null;
    if (!$id) {
        throw new Exception("ID de l'offre manquant !");
    }

    $offers = $user->getOffreById($id);
    if (empty($offers)) {
        throw new Exception("Aucune offre trouvée pour l'ID spécifié !");
    }

    $test = $user->isApplying($_SESSION['user_id'], $id);

    echo "Offre trouvée : <pre>" . print_r($offers, true) . "</pre>"; // Debug ici

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
        // Vérification de la session utilisateur
        $personcv = $_SESSION['user_id'] ?? null;
        if (!$personcv) {
            throw new Exception("L'utilisateur connecté n'a pas de CV enregistré !");
        }

        $offerId = $id;
        $exigence = $offers[0]['exigence'] ?? '';
        if (empty($exigence)) {
            throw new Exception("L'offre n'a pas d'exigence définie !");
        }

        // Transformer le CV en texte
        $cvtext = extractTextFromPdf($_FILES['pdfFile']);
        if (empty($cvtext['contenu']) || empty($cvtext['chemin'])) {
            throw new Exception("Le fichier PDF est invalide ou vide !");
        }

        // Debug: Afficher le texte extrait du PDF
        echo "Texte extrait du fichier PDF : " . $cvtext['contenu'] . "<br>";

        // Analyser le CV par rapport à l'exigence
        $resultatAnalyse = analyzeCV($cvtext['contenu'], $exigence);
        echo "Résultat de l'analyse : <pre>" . print_r($resultatAnalyse, true) . "</pre>";

        echo "tonga eto aloha";
        // Sauvegarder le CV et récupérer son ID
        $idCv = $user->saveCV(
            $personcv,
            $resultatAnalyse['education']['content'], $resultatAnalyse['education']['note'],
            $resultatAnalyse['experience']['content'], $resultatAnalyse['experience']['note'],
            $resultatAnalyse['competence']['content'], $resultatAnalyse['competence']['note'],
            $resultatAnalyse['remarque'], $cvtext['chemin']
        );

        echo "Tohizo";

        if (!$idCv) {
            throw new Exception("Échec de la sauvegarde du CV !");
        }

        echo $idCv . " : ID du CV enregistré.<br>";

        // Sauvegarder la candidature
        $applicationDate = $_POST['application_date'] ?? null;
        if (!$applicationDate) {
            throw new Exception("La date de candidature est manquante !");
        }

        // Exemple de sauvegarde (décommenter si nécessaire)
        /*
        if ($user->createApplication($offerId, $applicationDate, $idCv)) {
            echo "<p>Application successfully submitted!</p>";
            header('location:index.php?page=application');
            exit;
        } else {
            throw new Exception("Échec de l'envoi de la candidature !");
        }
        */
    }
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
}

?>


<h2>Apply for an Offer</h2>
<form method="post" action="index.php?page=applicationForm&id=<?= $id ?>"  enctype="multipart/form-data">

    <?php foreach ($offers as $offer): ?>
<p>Id :  <?= htmlspecialchars($offer['id']) ?></p>
<p>Job Title :  <?= htmlspecialchars($offer['job_name']) ?></p>
<p>Recruteur :  <?= htmlspecialchars($offer['demandeur']) ?></p>
<p>Date sortie :  <?= htmlspecialchars($offer['datecreation']) ?></p>
<p>Date limite :  <?= htmlspecialchars($offer['datefin']) ?></p>
<p>Exigence :  <?= htmlspecialchars($offer['exigence']) ?></p>

<?php endforeach; ?>
<?php if (count($test) == 0 ) { ?>
    <label>Date of Application:</label><br>
    <input type="date" name="application_date" required><br><br>
    <label for="pdfFile">Choisir un fichier PDF :</label><br>
    <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" required><br><br>
    <input type="submit" value="Apply">
    <?php }else{ ?>
        <p>You already applied .</p>
        
    <?php } ?>
</form>