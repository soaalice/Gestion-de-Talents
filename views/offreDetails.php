
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
    <table  class="table table-bordered shadow-lg" style="background-color: #ffffff;">
        <thead style="background-color: #a8d5a2; color: #2b7a2b;">
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
    <a href="index.php?page=recruiterDashboard" class="btn btn-success">Retour</a>
</div>
<style>
    .table-bordered {
        border: 1px solid #a8d5a2;
    }

    /* Design naturel avec des couleurs apaisantes et une mise en page fluide */
    body {
        background-color: #f5f5f5;
        /* Fond doux et naturel */
        font-family: 'Arial', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Style de l'offre d'emploi */
    .job-offer {
        background-color: #ffffff;
        padding: 30px;
        /* border-radius: 8px; */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .job-offer h2 {
        font-size: 24px;
        color: #107c41;
        /* Vert naturel */
        margin-bottom: 20px;
    }

    .job-offer p {
        font-size: 18px;
        margin: 10px 0;
    }

    .job-offer strong {
        color: #107c41;
    }

    /* Style des critères */
    .criteria {
        /* background-color: #ffffff; */
        padding: 30px;
        border-radius: 8px;
        /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); */
    }

    .criteria h2 {
        font-size: 24px;
        color: #107c41;
        /* Vert naturel */
        margin-bottom: 20px;
    }

    /* Table des critères */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        font-size: 16px;
    }

    th {
        background-color: #eaf4f0;
        /* Gris clair */
        color: #107c41;
        font-weight: bold;
    }

    td {
        background-color: #f9f9f9;
        color: #555;
    }

    tr:nth-child(even) td {
        background-color: #f1f1f1;
    }

    /* Lien retour */
    .back-link {
        display: inline-block;
        padding: 12px 25px;
        background-color: #107c41;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-top: 20px;
        text-align: center;
    }

    

    /* Footer Style */
    .footer {
        background-color: #107c41;
        color: #fff;
        padding: 15px 0;
        text-align: center;
        margin-top: 50px;
        font-size: 14px;
    }

    .footer p {
        margin: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .container {
            width: 90%;
        }

        .job-offer,
        .criteria {
            padding: 20px;
        }

        table th,
        table td {
            font-size: 14px;
            padding: 10px;
        }

        .back-link {
            padding: 10px 20px;
        }
    }
</style>