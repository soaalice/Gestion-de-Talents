<?php

// Récupérer les offres disponibles
$id = $_SESSION['user_id'];
$contract = $user->getMyContract($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = $_POST['idcontrat'];
    
    if ($user->ruptureContract($id,$con,$contract[0]['employeur_id'],Constante::id_demission())) {
        header('location:index.php?page=candidateDashboard');
        echo "<p>Task Accomplished!</p>";
    } else {
        echo "<p>Failed to achive the task.</p>";
    }
}


include('header.php');
?>
<?php if(!empty($contract) && isset($contract)){ ?>
<h2>Details of the Contract</h2>


<p>Date debut :  <?= htmlspecialchars($contract[0]['date_debut']) ?></p>
<p>Date fin :  <?= htmlspecialchars($contract[0]['date_fin']) ?></p>
<p>Statut :  <?= htmlspecialchars($contract[0]['statut_id']) ?></p>
<p>Employeur :  <?= htmlspecialchars($contract[0]['employeur_id']) ?></p>
    <form action="index.php?page=contract" method="post">
        <input type="hidden" name="idcontrat" value="<?= $contract[0]['id'] ?>">
        <input type="submit" value="Demissioner">
    </form>
<?php }else{ ?>
<p>Vous n'avez pas encore de contrat.</p>

<?php } ?>