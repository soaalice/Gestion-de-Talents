<?php

// Récupérer les offres disponibles
$id = $_SESSION['user_id'];
$contract = $user->getMyContract($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    if($type == "d"){
        $con = $_POST['idcontrat'];

        if ($user->ruptureContract($id,$con,$contract[0]['employeur_id'],Constante::id_demission())) {
            header('location:index.php?page=candidateDashboard');
            echo "<p>Task Accomplished!</p>";
        } else {
            echo "<p>Failed to achive the task.</p>";
        }
    }else{
        $ip = $_POST['id_ip'];
        $emp = $_POST['id_emp'];
        $date = $_POST['date'];

        if ($user->updateIndemnite($ip,$date,$emp)){
            header('location:index.php?page=candidateDashboard');
            echo "<p>Task Accomplished!</p>";   
        } else {
            echo "<p>Failed to achive the task.</p>";
        }
    }
}


include('header.php');
?><body>
<div class="container mt-5">

    <?php if (!empty($contract) && isset($contract)): ?>
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Détails du Contrat</h2>
            </div>
            <div class="card-body">
                <p><strong>Date de début :</strong> <?= htmlspecialchars($contract[0]['date_debut']) ?></p>
                <p><strong>Date de fin :</strong> <?= htmlspecialchars($contract[0]['date_fin']) ?></p>
                <p><strong>Salaire :</strong> <?= htmlspecialchars($contract[0]['salaire']) ?></p>
                <p><strong>Employeur :</strong> <?= htmlspecialchars($contract[0]['nom']) ?></p>
                <form action="index.php?page=contract" method="post">
                    <input type="hidden" name="idcontrat" value="<?= $contract[0]['id'] ?>">
                    <input type="hidden" name="type" value="d">
                    <button type="submit" class="btn btn-danger w-100">Démissionner</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center p-5">
            <p class="display-6 p-5">Vous n'avez pas de contrat en ce moment.</p>
        </div>

        <?php 
        $indemnite = $user->getIndemnite($_SESSION['user_id']); 
        if (count($indemnite) > 0): 
        ?>
            <div class="card">
                <div class="card-header text-center bg-warning text-dark">
                    <h2>Indemnité</h2>
                </div>
                <div class="card-body">
                    <p><strong>Montant :</strong> <?= htmlspecialchars($indemnite[0]['montant']) ?></p>
                    <form action="index.php?page=contract" method="post">
                        <input type="hidden" name="id_ip" value="<?= $indemnite[0]['id'] ?>">
                        <input type="hidden" name="id_emp" value="<?= $indemnite[0]['employeur_id'] ?>">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date de paiement</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <input type="hidden" name="type" value="p">
                        <button type="submit" class="btn btn-success w-100">Payer</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
