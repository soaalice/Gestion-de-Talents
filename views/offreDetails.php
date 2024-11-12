<?php 
    $recruiterId = $_SESSION['user_id']; // ID du recruteur connecté

    $idOffre = $_GET['offreid'];

    $job = $user->getOffreByJobId($idOffre);

    $jobDetails = $user->getRequisOffre($idOffre);

?>

<div class="job-offer">
    <h2>Offre d'emploi</h2>
    <p><strong>Poste :</strong> <?= htmlspecialchars($job[0]['nom']); ?></p>
    <p><strong>Date de l'offre :</strong> <?= htmlspecialchars($job[0]['dateoffre']); ?></p>
    <p><strong>Salaire :</strong> <?= htmlspecialchars($job[0]['salaire']); ?> MGA</p>
</div>

<div class="criteria">
    <h2>Critères de sélection</h2>
    <table>
        <thead>
            <tr>
                <th>Critère</th>
                <th>Minimum</th>
                <th>Maximum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobDetails as $jobDetail): ?>
                <tr>
                    <td><?= htmlspecialchars($jobDetail['nom']); ?></td>
                    <td><?= htmlspecialchars($jobDetail['minimum']); ?></td>
                    <td><?= htmlspecialchars($jobDetail['maximum']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php?page=recruiterDashboard">retour</a>
</div>
