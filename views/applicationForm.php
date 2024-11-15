<?php
// Récupérer les offres disponibles
$id = $_GET['id'];
$offers = $user->getOffreById($id);
$test = $user->isApplying($_SESSION['user_id'],$id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offerId = $id;
    $applicationDate = $_POST['application_date'];
    $personcv = $_SESSION['user_cv']; // L'ID de l'utilisateur connecté est supposé être dans la session

    if ($user->createApplication($offerId, $applicationDate, $personcv)) {
        echo "<p>Application successfully submitted!</p>";
        header('location:index.php?page=application');
    } else {
        echo "<p>Failed to submit application.</p>";
    }
}
?>
<h2>Apply for an Offer</h2>
<form method="post" action="index.php?page=applicationForm&id=<?= $id ?>">

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
    
    <input type="submit" value="Apply">
    <?php }else{ ?>
        <p>You already applied .</p>
        
    <?php } ?>
</form>