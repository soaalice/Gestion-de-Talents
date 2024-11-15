<?php
// Vérifier si l'utilisateur est authentifié et est un postulant
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'client') {
    header('Location: index.php?page=login');
    exit;
}

$userId = $_SESSION['user_id']; // ID du postulant connecté

// Récupérer les offres disponibles
$offers = $user->getAvailableOffers($_SESSION['user_cv']);

// Récupérer les candidatures du postulant
$applications = $user->getUserApplications($userId);
?>

<h2>Available Job Offers</h2>
<table border="1">
    <thead>
        <tr>
            <th>Offer ID</th>
            <th>Job Name</th>
            <th>Offer Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['offer_id']) ?></td>
                <td><?= htmlspecialchars($offer['job_name']) ?></td>
                <td><?= htmlspecialchars($offer['datecreation']) ?></td>
                <td>
                    <a href="index.php?page=detailOffre&&id=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Voir plus</button>
                    </a>
                        <a href="index.php?page=applicationForm&id=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Apply </button></a>
                    
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
            <th>Status Candidature</th>
            <th>Status Test Écrit</th>
            <th>Status Test Oral</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application):?>
        <?php
            // Récupération des statuts pour chaque candidature
            $compatibility = $user->getApplicationCompatibility($application['candidature_id']);
            $writtenTestStatus = $user->getWrittenTestStatus($application['candidature_id']);
            $oralTestStatus = $user->getOralTestStatus($application['candidature_id']);
        ?>      
            <tr>
                <td><?= htmlspecialchars($application['candidature_id']) ?></td>
                <td><?= htmlspecialchars($application['job_name']) ?></td>
                <td><?= htmlspecialchars($application['datecandidature']) ?></td>
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
                            $noteWrittenTest = $writtenTestStatus['note'];
                            $style = $user->getStyleForNote(1, $noteWrittenTest);
                            echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                        } else {
                            echo '<span>Pas encore évalué</span>';
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
                                $noteOralTest = $oralTestStatus['note'];
                                $style = $user->getStyleForNote(2, $noteOralTest);
                                echo '<span style="' . $style . '">Note: ' . number_format($noteOralTest, 2) . '</span>';
                            } else {
                                echo '<span>Pas encore évalué</span>';
                            }
                        }
                    }
                    ?>
                </td>
                <td><a href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($application['idoffre']) ?>&&idcandidat=<?= htmlspecialchars($application['candidature_id']) ?>"><button>Voir
                            plus</button> </a></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>