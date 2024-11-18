<?php
// Récupérer les offres disponibles
$cv = $user->getCVbyId($_SESSION['user_id']);
$com = "";
$exp = "";
$ed = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $com = $_POST['com'];
    $exp = $_POST['exp'];
    $ed = $_POST['ed'];
    $id = $_SESSION['user_id']; // L'ID de l'utilisateur connecté est supposé être dans la session
    $cv = $_SESSION['user_cv']; // L'ID de l'utilisateur connecté est supposé être dans la session

    if ($user->createORreplaceCV($com, $exp, $ed,$id,$cv)) {
        echo "<p>Task Accomplished!</p>";
    } else {
        echo "<p>Failed to achive the task.</p>";
    }
}
?>
<h2>My CV :</h2>
<?php if(count($cv) > 0 ) {
    $com = $cv[0]['competence'];
    $exp = $cv[0]['experience'];
    $ed = $cv[0]['education'];
    ?>
    
    <p>Competence :  <?= htmlspecialchars($com) ?></p>
    <p>Experience :  <?= htmlspecialchars($exp) ?></p>
    <p>Education :  <?= htmlspecialchars($ed) ?></p>
    <button id="btnAfficher">Modifier</button>
    <?php }else{ ?>
        <button id="btnAfficher">Creer un cv</button>
    <?php } ?>
<div id="form" style="display: none;">
    
    <form method="post" action="index.php?page=creationCV">

        

        <label>Competence :</label><br>
        <input type="text" name="com" value=" <?= htmlspecialchars($com) ?>" required><br><br>
        
        <label>Experience:</label><br>
        <input type="text" name="exp" value=" <?= htmlspecialchars($exp) ?>" required><br><br>
        
        <label>Education:</label><br>
        <input type="text" name="ed" value=" <?= htmlspecialchars($ed) ?>" required><br><br>
        
        <input type="submit" value="Valider">
        
        
    </form>
</div>

<script>
var boutonAfficher = document.getElementById('btnAfficher');
var contenu = document.getElementById('form');

// Ajouter un gestionnaire d'événements au bouton
boutonAfficher.addEventListener('click', function () {
  // Basculer l'affichage de l'élément
  if (contenu.style.display === 'none') {
    contenu.style.display = 'block'; // Affiche le contenu
  } else {
    contenu.style.display = 'none'; // Masque le contenu
  }
});

</script>