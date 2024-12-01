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
?><div class="container">
    <div class="my-3">
        <h2>Liste des Employés Actifs</h2>
    </div>
<div class="table-container">
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['id']) ?></td>
                <td><?= htmlspecialchars($offer['nom']) ?></td>
                <td>
                    <form action="index.php?page=listeEmploye" method="post" class="d-inline">
                        <input type="hidden" name="idcontrat" value="<?= $offer['id'] ?>">
                        <input type="hidden" name="type" value="l">
                        <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm btn-action">Licencier</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="my-3">
    <h2>Liste des Employés en Préavis</h2>
</div>
<div class="table-container">
    <table class="table table-striped table-bordered">
        <thead class="table-warning">
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offersPreavis as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['employe_id']) ?></td>
                <td><?= htmlspecialchars($offer['nom']) ?></td>
                <td>
                    <form action="index.php?page=listeEmploye" method="post" class="d-inline">
                        <input type="hidden" name="preavis_id" value="<?= $offer['preavis_id'] ?>">
                        <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
                        <input type="hidden" name="type" value="t">
                        <button type="submit" class="btn btn-success btn-sm btn-action">Terminer</button>
                    </form>
                    <form action="index.php?page=listeEmploye" method="post" class="d-inline">
                        <input type="hidden" name="preavis_id" value="<?= $offer['preavis_id'] ?>">
                        <input type="hidden" name="idemp" value="<?= $offer['employe_id'] ?>">
                        <input type="hidden" name="type" value="nr">
                        <input type="hidden" name="salaire" value="<?= $offer['salaire'] ?>">
                        <button type="submit" class="btn btn-warning btn-sm btn-action">Non respecter</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="my-3">
    <h2>Liste des Employés payant des Indemnités</h2>
</div>
<div class="table-container">
    <table class="table table-striped table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Id</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offersPreavisI as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['employe_id']) ?></td>
                <td><?= htmlspecialchars($offer['nom']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
