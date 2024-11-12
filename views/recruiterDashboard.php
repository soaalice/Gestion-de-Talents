<?php
// Vérifier si l'utilisateur est authentifié et est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'recruteur') {
    header('Location: index.php?page=login');
    exit;
}

$recruiterId = $_SESSION['user_id']; // ID du recruteur connecté

// Récupérer les offres du recruteur
$offers = $user->getRecruiterOffers($recruiterId);

// Récupérer les candidatures pour ces offres
$applications = $user->getRecruiterApplications($recruiterId);
?>

<h2>My Job Offers</h2>
<table border="1">
    <thead>
        <tr>
            <th>Offer ID</th>
            <th>Job Name</th>
            <th>Salary</th>
            <th>Offer Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['offer_id']) ?></td>
                <td><?= htmlspecialchars($offer['job_name']) ?></td>
                <td><?= htmlspecialchars($offer['salaire']) ?> €</td>
                <td><?= htmlspecialchars($offer['dateoffre']) ?></td>
                <td><a href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Voir plus</button> </a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Applications for My Offers</h2>
<table border="1">
    <thead>
        <tr>
            <th>Application ID</th>
            <th>Candidate Name</th>
            <th>Job Name</th>
            <th>Application Date</th>
            <th>Status Candidature</th>
            <th>Status Test Écrit</th>
            <th>Status Test Oral</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application):
            $compatibility = $user->getApplicationCompatibility($application['candidature_id']);
            $writtenTestStatus = $user->getWrittenTestStatus($application['candidature_id']);
            $oralTestStatus = $user->getOralTestStatus($application['candidature_id']);
        ?>
            <tr>
                <td><?= htmlspecialchars($application['candidature_id']) ?></td>
                <td><?= htmlspecialchars($application['candidate_name']) ?></td>
                <td><?= htmlspecialchars($application['job_name']) ?></td>
                <td><?= htmlspecialchars($application['datecandidature']) ?></td>
                <!-- Statut Candidature -->
                <td>
                    <?php
                    if ($compatibility == 1) {
                        echo '<span style="color: red;">Incompatible</span>';
                    } elseif ($compatibility == 2) {
                        echo '<span style="color: green;">Compatible</span>';
                    } else {
                        echo '<span>Surcompatible</span>';
                    }
                    ?>
                </td>
                
                <!-- Statut Test Écrit -->
                <td>
                    <?php
                    if ($compatibility == 1) {
                        echo 'N/A'; // Si incompatible, pas de test écrit
                    } elseif ($compatibility == 2 || $compatibility == 3) {
                        if ($writtenTestStatus) {
                            // echo 'Note: ' . number_format($writtenTestStatus['note'], 2); // Affiche la note du test écrit
                            $noteWrittenTest = $writtenTestStatus['note'];
                            $style = $user->getStyleForNote(1, $noteWrittenTest);
                            echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                        } else {
                            echo '<a href="index.php?page=writtenTestForm&applicationId=' . $application['candidature_id'] . '">Évaluer</a>';
                        }
                    }
                    ?>
                </td>
                
                <!-- Statut Test Oral -->
                <td>
                    <?php
                    if ($compatibility == 1) {
                        echo 'N/A'; // Si incompatible, pas de test oral
                    } elseif ($compatibility == 2 || $compatibility == 3) {
                        if (!$writtenTestStatus) {
                            echo 'Effectuer Préalablement le Test Écrit';
                        } else {
                            if ($oralTestStatus) {
                                // echo 'Note: ' . number_format($oralTestStatus['note'], 2); // Affiche la note du test oral
                                $noteWrittenTest = $oralTestStatus['note'];
                                $style = $user->getStyleForNote(2, $noteWrittenTest);
                                echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                            } else {
                                echo '<a href="index.php?page=oralTestForm&applicationId=' . $application['candidature_id'] . '">Évaluer</a>';
                            }
                        }
                    } else {
                        echo 'Surcompatible';
                    }
                    ?>
                </td>
                <td><a href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($application['idoffre']) ?>&&idcandidat=<?= htmlspecialchars($application['candidature_id']) ?>"><button>Voir plus</button> </a></td>

                <!-- <td>
                    <?php if (!$application['istaken']): ?>
                        <form action="index.php?page=updateTakenStatus" method="post">
                            <input type="hidden" name="candidature_id" value="<?= htmlspecialchars($application['candidature_id']) ?>">
                            <button type="submit">Attribuer l'Offre</button>
                        </form>
                    <?php else: ?>
                        <span>Already Taken</span>
                    <?php endif; ?>
                </td> -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>