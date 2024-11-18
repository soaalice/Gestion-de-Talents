<?php
// Vérifier si l'utilisateur est authentifié et est un recruteur
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$recruiterId = $_SESSION['user_id']; // ID du recruteur connecté

// Récupérer les offres du recruteur
$offers = $user->getRecruiterOffers($recruiterId);

// Récupérer les candidatures pour ces offres
$applications = $user->getCvDashboardInfoOffreRecruter($recruiterId);
?>

<h2>My Job Offers</h2>
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
                <td><a href="index.php?page=detailOffre&&id=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Voir plus</button> </a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Applications for My Offers</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID Candidature</th>
            <th>Nom de la Personne</th>
            <th>Nom du Job</th>
            <th>Moyenne des Notes</th>
            <th>Date de Postulation</th>
            <th>Status Candidature</th>
            <th>Status Test Écrit</th>
            <th>Status Test Oral</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application):
            $writtenTestStatus = $user->getWrittenTestStatus($application['id_candidature']);
            $oralTestStatus = $user->getOralTestStatus($application['id_candidature']);
        ?>
            <tr>
                <td><?php echo htmlspecialchars($application['id_candidature']); ?></td>
                <td><?php echo htmlspecialchars($application['nom_personne']); ?></td>
                <td><?php echo htmlspecialchars($application['nom_job']); ?></td>
                <td><?php echo htmlspecialchars($application['moyenne_notes']); ?></td>
                <td><?php echo htmlspecialchars($application['datepostule']); ?></td>
                <!-- Statut Candidature -->
                <td>
                    <?php
                    if ($application['moyenne_notes'] < 2 ) {
                        echo '<span style="color: red;">Incompatible</span>';
                    } elseif ($application['moyenne_notes'] > 2 && $application['moyenne_notes'] < 4) {
                        echo '<span style="color: green;">Compatible</span>';
                    } else {
                        echo '<span>Surcompatible</span>';
                    }
                    ?>
                </td>
                
                <!-- Statut Test Écrit -->
                <td>
                    <?php
                    if ($application['moyenne_notes'] < 2) {
                        echo 'N/A'; // Si incompatible, pas de test écrit
                    } elseif ($application['moyenne_notes']  > 2) {
                        if ($writtenTestStatus) {
                            // echo 'Note: ' . number_format($writtenTestStatus['note'], 2); // Affiche la note du test écrit
                            $noteWrittenTest = $writtenTestStatus['note'];
                            $style = $user->getStyleForNote(1, $noteWrittenTest);
                            echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                        } else {
                            echo '<a href="index.php?page=writtenTestForm&applicationId=' . $application['id_candidature'] . '">Évaluer</a>';
                        }
                    }
                    ?>
                </td>
                
                <!-- Statut Test Oral -->
                <td>
                    <?php
                    if ($application['moyenne_notes'] < 2) {
                        echo 'N/A'; // Si incompatible, pas de test oral
                    } elseif ($application['moyenne_notes'] > 2) {
                        if (!$writtenTestStatus) {
                            echo 'Effectuer Préalablement le Test Écrit';
                        } else {
                            if ($oralTestStatus) {
                                // echo 'Note: ' . number_format($oralTestStatus['note'], 2); // Affiche la note du test oral
                                $noteWrittenTest = $oralTestStatus['note'];
                                $style = $user->getStyleForNote(2, $noteWrittenTest);
                                echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                            } else {
                                echo '<a href="index.php?page=oralTestForm&applicationId=' . $application['id_candidature'] . '">Évaluer</a>';
                            }
                        }
                    } else {
                        echo 'Surcompatible';
                    }
                    ?>
                </td>
                <!-- <td><a href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($application['id_offre']) ?>&&idcandidat=<?= htmlspecialchars($application['id_candidature']) ?>"><button>Voir plus</button> </a></td> -->
                <td><a href="index.php?page=detailOffre&&id=<?= htmlspecialchars($application['id_offre']) ?>&&idcandidat=<?= htmlspecialchars($application['id_candidature']) ?>"><button>Voir plus</button> </a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
