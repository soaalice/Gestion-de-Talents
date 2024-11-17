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

include 'header.php';
?>

<div class="container mt-5 mb-5 pb-5">
    <div>

        <div class="m-3 mb-4">
            <h2 class="text-center" style="color: #3a6a40;">My Job Offers</h2>
        </div>

        <!-- Tableau des offres -->
        <table class="table table-bordered shadow-lg" style="background-color: #ffffff;">
            <thead style="background-color: #a8d5a2; color: #2b7a2b;">
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
                    <tr style="background-color: #ffffff;">
                        <td><?= htmlspecialchars($offer['offer_id']) ?></td>
                        <td><?= htmlspecialchars($offer['job_name']) ?></td>
                        <td><?= htmlspecialchars($offer['salaire']) ?> €</td>
                        <td><?= htmlspecialchars($offer['dateoffre']) ?></td>
                        <td><a href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($offer['offer_id']) ?>"><button
                                    class="btn btn-outline-success">Voir plus</button></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-5">

        <div class="m-3 mb-4">
            <h2 class="text-center" style="color: #3a6a40;">Applications for My Offers</h2>
        </div>

        <!-- Tableau des candidatures -->
        <table class="table table-bordered shadow-lg" style="background-color: #ffffff;">
            <thead style="background-color: #a8d5a2; color: #2b7a2b;">
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
                    <tr style="background-color: #ffffff;">
                        <td><?= htmlspecialchars($application['candidature_id']) ?></td>
                        <td><?= htmlspecialchars($application['candidate_name']) ?></td>
                        <td><?= htmlspecialchars($application['job_name']) ?></td>
                        <td><?= htmlspecialchars($application['datecandidature']) ?></td>
                        <td>
                            <?php
                            if ($compatibility == 1) {
                                echo '<span style="color: red;">Incompatible</span>';
                            } elseif ($compatibility == 2) {
                                echo '<span style="color: green;">Compatible</span>';
                            } else {
                                echo '<span style="color: #1c7c54;">Surcompatible</span>';
                            }
                            ?>
                        </td>
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
                                    echo '<a href="index.php?page=writtenTestForm&applicationId=' . $application['candidature_id'] . '" class="btn btn-outline-success">Évaluer</a>';
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($compatibility == 1) {
                                echo 'N/A';
                            } elseif ($compatibility == 2 || $compatibility == 3) {
                                if (!$writtenTestStatus) {
                                    echo 'Effectuer Préalablement le Test Écrit';
                                } else {
                                    if ($oralTestStatus) {
                                        $noteWrittenTest = $oralTestStatus['note'];
                                        $style = $user->getStyleForNote(2, $noteWrittenTest);
                                        echo '<span style="' . $style . '">Note: ' . number_format($noteWrittenTest, 2) . '</span>';
                                    } else {
                                        echo '<a href="index.php?page=oralTestForm&applicationId=' . $application['candidature_id'] . '" class="btn btn-outline-success">Évaluer</a>';
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><a
                                href="index.php?page=detailOffre&&offreid=<?= htmlspecialchars($application['idoffre']) ?>&&idcandidat=<?= htmlspecialchars($application['candidature_id']) ?>"><button
                                    class="btn btn-outline-primary">Voir+</button></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- CSS personnalisé pour le thème nature et écologie -->
<style>
    .table-bordered {
        border: 1px solid #a8d5a2;
    }

    .table thead {
        background-color: #a8d5a2;
        color: #2b7a2b;
    }

    .btn-outline-success {
        color: #3a6a40;
        border-color: #3a6a40;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #3a6a40;
        color: #fff;
    }

    .btn-outline-primary {
        color: #2b7a2b;
        border-color: #2b7a2b;
    }

    .btn-outline-primary:hover {
        background-color: #2b7a2b;
        color: #fff;
    }
</style>