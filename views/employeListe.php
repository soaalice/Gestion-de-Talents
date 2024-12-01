<?php
$id = $_SESSION['user_id'];
$offers = $user->getEmployes($id);
$offersPreavis = $user->getEmployesPreavis($id);
$offersPreavisI = $user->getEmployesPreavisIndemnite($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $emp = $_POST['idemp'];
    if ($type == "l") {
        $con = $_POST['idcontrat'];
        if ($user->ruptureContract($emp,$con,$id,Constante::id_licenciement())) {
            header('location:index.php?page=candidateDashboard');
            echo "<p>Task Accomplished!</p>";
        } else {
            echo "<p>Failed to achive the task.</p>";
        }
    }else if ($type == "t") {
        $pr = $_POST['preavis_id'];
        if ($user->updatePreavis($pr,Constante::id_terminer())) {
            $user->insertNotifs("Vous n'etes plus sous contrat.",$emp);
            header('location:index.php?page=listeEmploye');
            echo "<p>Task Accomplished!</p>";
        } else {
            echo "<p>Failed to achive the task.</p>";
        }
    }else{
        $pr = $_POST['preavis_id'];
        $s = $_POST['salaire'];
        if ($user->createIndemnite($pr,Constante::id_en_attente(),$s,$emp)) {
            header('location:index.php?page=listeEmploye');
            echo "<p>Task Accomplished!</p>";
        } else {
            echo "<p>Failed to achive the task.</p>";
        }
    }
    
   
}
include('header.php');
?>
<h2>List Employes Actives:</h2>
<table border="1">
    <tr>
        <td>Id</td>
        <td>Nom</td>
        <td>Action</td>
    </tr>
    <?php foreach ($offers as $offer): ?>
    <tr>
        <td><?= htmlspecialchars($offer['id']) ?></td>
        <td><?= htmlspecialchars($offer['nom']) ?></td>
        <form action="index.php?page=listeEmploye" method="post">
            <input type="hidden" name="idcontrat" value="<?= $offer['id'] ?>">
            <input type="hidden" name="type" value="l">
            <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
            <td> <input type="submit" value="Licencier"></td>
        </form> 
       
    </tr>
        <?php endforeach; ?>
</table>
<h2>List Employes in Preavis :</h2>
<table border="1">
    <tr>
        <td>Id</td>
        <td>Nom</td>
        <td>Action</td>
    </tr>
    <?php foreach ($offersPreavis as $offer): ?>
    <tr>
        <td><?= htmlspecialchars($offer['employe_id']) ?></td>
        <td><?= htmlspecialchars($offer['nom']) ?></td>
        <form action="index.php?page=listeEmploye" method="post">
            <input type="hidden" name="preavis_id" value="<?= $offer['preavis_id'] ?>">
            <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
            <input type="hidden" name="type" value="t">
            <td> <input type="submit" value="Terminer"></td>
        </form> 
        <form action="index.php?page=listeEmploye" method="post">
            <input type="hidden" name="preavis_id" value="<?= $offer['preavis_id'] ?>">
            <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
            <input type="hidden" name="type" value="nr">
            <input type="hidden" name="salaire" value="<?= $offer['salaire'] ?>">
            <td> <input type="submit" value="Non respecter"></td>
        </form> 
    </tr>
        <?php endforeach; ?>
</table>
<h2>List Employes payant les indemnites:</h2>
<table border="1">
    <tr>
        <td>Id</td>
        <td>Nom</td>
        <td>Action</td>
    </tr>
    <?php foreach ($offersPreavisI as $offer): ?>
    <tr>
        <td><?= htmlspecialchars($offer['employe_id']) ?></td>
        <td><?= htmlspecialchars($offer['nom']) ?></td>
       
       
    </tr>
        <?php endforeach; ?>
</table>