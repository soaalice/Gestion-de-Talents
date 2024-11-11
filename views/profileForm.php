<?php
// Récupérer les offres disponibles pour le postulant
$offers = $user->getUserApplicationsForProfile($_SESSION['user_id']);

// Vérifier si un postulant a sélectionné une offre et récupérer les requis
$requis = [];
if (isset($_POST['offer_id'])) {
    $offerId = $_POST['offer_id'];
    $requis = $user->getRequisForOffer($offerId); // Récupérer les requis pour cette offre
}

// Gestion du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_data'])) {
    $offerId = $_POST['offer_id'];
    $profileData = $_POST['profile_data']; // Récupérer les données du profil

    // Insérer les valeurs du profil dans la table Profile
    foreach ($profileData as $requisId => $value) {
        $user->createProfile($_SESSION['user_id'], $requisId, $value); // Ajouter dans la table Profile
    }

    echo "<p>Profile updated successfully!</p>";
}
?>

<h2>Fill Your Profile for an Offer</h2>

<form method="post" action="index.php?page=profileForm">
    <label>Offer:</label><br>
    <select name="offer_id" required onchange="this.form.submit()">
        <option value="" disabled selected>Select an offer</option>
        <?php foreach ($offers as $offer): ?>
            <option value="<?= htmlspecialchars($offer['offer_id']) ?>" <?= isset($offerId) && $offer['offer_id'] == $offerId ? 'selected' : '' ?>>
                <?= htmlspecialchars($offer['job_name']) ?> - Salary: <?= htmlspecialchars($offer['salaire']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <?php if (!empty($requis)){ ?>
        <div id="profileFields">
            <?php foreach ($requis as $requi): ?>
                <label><?= htmlspecialchars($requi['nom']) ?>:</label><br>
                <input type="text" name="profile_data[<?= $requi['id'] ?>]" required><br><br>
            <?php endforeach; ?>
        </div>
        <input type="submit" value="Submit Profile">
        <?php } else {
    echo "<p>No requirements found for this offer.</p>";
} ?>
</form>

<script>
    // Fonction pour mettre à jour le type des champs en fonction du type de requis
function updateInputType() {
    const requisElements = document.querySelectorAll('#profileFields input');

    requisElements.forEach(input => {
        const requiId = input.name.split('[')[1].split(']')[0];  // ID du requis
        const requis = requisData.find(r => r.id === parseInt(requiId)); // Trouver le requis

        // Mettre à jour le type de champ en fonction du type du requis
        if (requis) {
            switch(requis.type_name) {
                case 'varchar':
                    input.type = 'text';
                    break;
                case 'int':
                    input.type = 'number';
                    break;
                case 'decimal':
                    input.type = 'number';
                    input.step = '0.01';
                    break;
                case 'date':
                    input.type = 'date';
                    break;
                case 'timestamp':
                    input.type = 'datetime-local';
                    break;
                case 'boolean':
                    input.type = 'checkbox';
                    break;
            }
        }
    });
}

// Vous pouvez appeler cette fonction après le chargement du formulaire
updateInputType();

</script>