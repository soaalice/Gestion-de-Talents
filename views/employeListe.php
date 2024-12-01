<?php
$id = $_SESSION['user_id'];
$offers = $user->getEmployes($id);
$offersPreavis = $user->getEmployesPreavis($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = $_POST['idcontrat'];
    $emp = $_POST['idemp'];
    
    if ($user->ruptureContract($emp,$con,$id,Constante::id_licenciement())) {
        header('location:index.php?page=candidateDashboard');
        echo "<p>Task Accomplished!</p>";
    } else {
        echo "<p>Failed to achive the task.</p>";
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
    </tr>
    <?php foreach ($offersPreavis as $offer): ?>
    <tr>
        <td><a href="index.php?page=contractForm&&id=<?= htmlspecialchars($offer['id']) ?>"><button><?= htmlspecialchars($offer['id']) ?></button> </a></td>
        <td><?= htmlspecialchars($offer['nom']) ?></td>
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
    <?php foreach ($offers as $offer): ?>
    <tr>
        <td><?= htmlspecialchars($offer['id']) ?></td>
        <td><?= htmlspecialchars($offer['nom']) ?></td>
       
       
    </tr>
        <?php endforeach; ?>
</table>