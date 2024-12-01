<?php
// Vérifier si l'utilisateur est authentifié et est un postulant
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'client') {
    header('Location: index.php?page=login');
    exit;
}
include "header.php";
$userId = $_SESSION['user_id']; // ID du postulant connecté

// Récupérer les offres disponibles
$offers = $user->getAvailableOffers();

// Récupérer les candidatures du postulant
$infos = $user->getCvDashboardInfoPerson($userId);
?>
<div class="container">
    <div class="mt-5 mb-5">

<h2 class = "text-success"> Available Job Offers</h2>
<table class="table table-bordered table-striped table-hover">
    <thead class = "bg-success text-white">
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
</div>
<div class = "mb-5 mt-5">
  
<h2 class = "text-success"> My Applications</h2>
<table class="table table-bordered table-striped table-hover">
    <thead class = "bg-success text-white">
        <tr>
            <th>ID Candidature</th>
            <th>Nom de la Personne</th>
            <th>Nom du Job</th>
            <th>Moyenne des Notes</th>
            <th>Date de Postulation</th>
            <th>Status Candidature</th>
            <th>Status Test Écrit</th>
            <th>Status Test Oral</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($infos as $application):?>
        <?php
            // // Récupération des statuts pour chaque candidature
            //  $compatibility = $user->getApplicationCompatibility($application['candidature_id']);
            $writtenTestStatus = $user->getWrittenTestStatus($application['id_candidature']);
            $oralTestStatus = $user->getOralTestStatus($application['id_candidature']);
        ?>      
            <tr>
                <td><?php echo htmlspecialchars($application['id_candidature']); ?></td>
                <td><?php echo htmlspecialchars($application['nom_personne']); ?></td>
                <td><?php echo htmlspecialchars($application['nom_job']); ?></td>
                <td><?php echo htmlspecialchars($application['moyenne_notes']); ?></td>
                <td><?php echo htmlspecialchars($application['datepostule']); ?></td>
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
                    } elseif ($application['moyenne_notes'] > 2) {
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
                <td>
                    <?php
                    if ($application['moyenne_notes'] < 2) {
                        echo 'N/A'; // Si incompatible, pas de test oral
                    } elseif ($application['moyenne_notes'] > 2 ) {
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

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

