<?php

include('header.php');
// Récupérer les offres disponibles
$id = $_GET['id'];
$offers = $user->getOffreById($id);


?>
<h2>Details of the Offer</h2>

    <?php foreach ($offers as $offer): ?>
<p>Id :  <?= htmlspecialchars($offer['id']) ?></p>
<p>Job Title :  <?= htmlspecialchars($offer['job_name']) ?></p>
<p>Date sortie :  <?= htmlspecialchars($offer['datecreation']) ?></p>
<p>Date limite :  <?= htmlspecialchars($offer['datefin']) ?></p>
<p>Exigence :  <?= htmlspecialchars($offer['exigence']) ?></p>

<?php endforeach; ?>
