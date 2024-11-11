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

<h2>Available Job Offers</h2>
<table border="1">
    <thead>
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
                    <form method="post" action="index.php?page=applicationForm">
                        <input type="hidden" name="offer_id" value="<?= htmlspecialchars($offer['offer_id']) ?>">
                        <input type="submit" value="Apply">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>My Applications</h2>
<table border="1">
    <thead>
        <tr>
            <th>Application ID</th>
            <th>Job Name</th>
            <th>Application Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= htmlspecialchars($application['candidature_id']) ?></td>
                <td><?= htmlspecialchars($application['job_name']) ?></td>
                <td><?= htmlspecialchars($application['datecandidature']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>