<?php 
    $recruiterId = $_SESSION['user_id']; // ID du recruteur connecté
    $idOffre = $_GET['offreid'];
    $job = $user->getOffreByJobId($idOffre);

    $idCandidature; $idPersonne; $offreDetails;
    $jobDetails = $user->getRequisOffre($idOffre);

    $wValue = isset($_GET['idcandidat']);
    if ($wValue) {
        $idCandidature = $_GET['idcandidat'];
        $idPersonne = $user->getPersonneIdByCandidatureId($idCandidature);
        $offreDetails = $user->getOffreDetails($idOffre, $idPersonne);
    }
?>

<div class="job-offer">
    <h2>Offre d'emploi</h2>
    <p><strong>Poste :</strong> <?= htmlspecialchars($job[0]['nom']); ?></p>
    <p><strong>Date de l'offre :</strong> <?= htmlspecialchars($job[0]['dateoffre']); ?></p>
    <p><strong>Salaire :</strong> <?= htmlspecialchars($job[0]['salaire']); ?> MGA</p>
</div>

<div class="criteria">
    <h2>Critères de sélection <?php if ($wValue): ?> pour <?= htmlspecialchars($offreDetails[0]['nom_candidat']); ?> <?php endif; ?>
    </h2>
    <table>
        <thead>
            <tr>
                <th>Critère</th>
                <th>Minimum</th>
                <th>Maximum</th>
                <?php if ($wValue): ?>
                <th>Valeur</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($wValue) {
                foreach ($offreDetails as $offerD) { ?>
                <tr>
                    <td><?= htmlspecialchars($offerD['nom_requis']); ?></td>
                    <td><?= htmlspecialchars($offerD['minimum']); ?></td>
                    <td><?= htmlspecialchars($offerD['maximum']); ?></td>
                    <td><?= htmlspecialchars($offerD['valeur']); ?></td>
                </tr>
            <?php }} else { 
                foreach ($jobDetails as $jobDetail){ ?>
                <tr>
                    <td><?= htmlspecialchars($jobDetail['nom']); ?></td>
                    <td><?= htmlspecialchars($jobDetail['minimum']); ?></td>
                    <td><?= htmlspecialchars($jobDetail['maximum']); ?></td>
                </tr>
            <?php }} ?>
        </tbody>
    </table>
    <a href="index.php?page=recruiterDashboard">retour</a>
</div>
