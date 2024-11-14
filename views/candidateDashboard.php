<?php
// Vérifier si l'utilisateur est authentifié et est un postulant
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'postulant') {
    header('Location: index.php?page=login');
    exit;
}

$userId = $_SESSION['user_id']; // ID du postulant connecté

// Récupérer les offres disponibles
$offers = $user->getAvailableOffers();

// Récupérer les candidatures du postulant
$applications = $user->getUserApplications($userId);
?>
<div class="container">
    <div class="mt-5 mb-5">

        <h2 class="text-success">Available Job Offers</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-success text-white">
                <tr>
                    <th>Offer ID</th>
                    <th>Job Name</th>
                    <th>Salary</th>
                    <th>Offer Date</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offers as $offer): ?>
                    <tr>
                        <td><?= htmlspecialchars($offer['offer_id']) ?></td>
                        <td><?= htmlspecialchars($offer['job_name']) ?></td>
                        <td><?= htmlspecialchars($offer['salaire']) ?> €</td>
                        <td><?= htmlspecialchars($offer['dateoffre']) ?></td>
                        <td>
                            <form method="post" action="index.php?page=applicationForm" class="d-inline">
                                <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['offer_id']) ?>">
                                <button type="submit" class="btn btn-outline-success">Apply</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class=" mt-5 mb-5">

        <h2 class="text-success">My Applications</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-success text-white">
                <tr>
                    <th>Application ID</th>
                    <th>Job Name</th>
                    <th>Application Date</th>
                    <th>Status Candidature</th>
                    <th>Status Test Écrit</th>
                    <th>Status Test Oral</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <?php
                    $compatibility = $user->getApplicationCompatibility($application['candidature_id']);
                    $writtenTestStatus = $user->getWrittenTestStatus($application['candidature_id']);
                    $oralTestStatus = $user->getOralTestStatus($application['candidature_id']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($application['candidature_id']) ?></td>
                        <td><?= htmlspecialchars($application['job_name']) ?></td>
                        <td><?= htmlspecialchars($application['datecandidature']) ?></td>
                        <td>
                            <?php if ($compatibility == 1): ?>
                                <span class="text-danger">Incompatible</span>
                            <?php elseif ($compatibility == 2): ?>
                                <span class="text-success">Compatible</span>
                            <?php else: ?>
                                <span class="text-primary">Surcompatible</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($compatibility == 1): ?>
                                N/A
                            <?php elseif ($compatibility == 2 || $compatibility == 3): ?>
                                <?php if ($writtenTestStatus): ?>
                                    <span class="<?= $user->getStyleForNoteClass(1, $writtenTestStatus['note']) ?>">Note:
                                        <?= number_format($writtenTestStatus['note'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Pas encore évalué</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($compatibility == 1): ?>
                                N/A
                            <?php elseif ($compatibility == 2 || $compatibility == 3): ?>
                                <?php if (!$writtenTestStatus): ?>
                                    <span class="text-warning">Effectuer Préalablement le Test Écrit</span>
                                <?php elseif ($oralTestStatus): ?>
                                    <span class="<?= $user->getStyleForNoteClass(2, $oralTestStatus['note']) ?>">Note:
                                        <?= number_format($oralTestStatus['note'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Pas encore évalué</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>