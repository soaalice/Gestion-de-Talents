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
?>
<?php if(!empty($contract) && isset($contract)){ ?>
<h2>Details of the Contract</h2>


<p>Date debut :  <?= htmlspecialchars($contract[0]['date_debut']) ?></p>
<p>Date fin :  <?= htmlspecialchars($contract[0]['date_fin']) ?></p>
<p>Salaire :  <?= htmlspecialchars($contract[0]['salaire']) ?></p>
<p>Employeur :  <?= htmlspecialchars($contract[0]['nom']) ?></p>
    <form action="index.php?page=contract" method="post">
        <input type="hidden" name="idcontrat" value="<?= $contract[0]['id'] ?>">
        <input type="hidden" name="type" value="d">
        <input type="submit" value="Demissioner">
    </form>
    <?php }else{ ?>
        <p>Vous n'avez pas de contrat en ce moment.</p>
        
        
        <?php
    $indemnite = $user->getIndemnite($_SESSION['user_id']);
if(count($indemnite) > 0){
    ?>

<p>Montant :  <?= htmlspecialchars($indemnite[0]['montant']) ?></p>

<form action="index.php?page=contract" method="post">
    <input type="hidden" name="id_ip" value="<?= $indemnite[0]['id'] ?>">
    <input type="hidden" name="id_emp" value="<?= $indemnite[0]['employeur_id'] ?>">
    <input type="date" name="date" >
    <input type="hidden" name="type" value="p">
        <input type="submit" value="Payer">
    </form>
<?php } ?>
<?php } ?>