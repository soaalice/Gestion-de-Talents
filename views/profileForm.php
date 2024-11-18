<?php
// Récupérer les offres disponibles pour le postulant
$offers = $user->getUserApplicationsForProfile($_SESSION['user_id']);

// Vérifier si un postulant a sélectionné une offre et récupérer les requis
$requis = [];
if (isset($_POST['offer_id'])) {
    $offerId = $_POST['offer_id'];
    $requis = $user->getRequisForOffer($offerId); // Récupérer les requis pour cette offre
}
include 'header.php';

// Gestion du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_data'])) {
    $offerId = $_POST['offer_id'];
    $profileData = $_POST['profile_data']; // Récupérer les données du profil

    // Insérer les valeurs du profil dans la table Profile
    foreach ($profileData as $requisId => $value) {
        $user->createProfile($_SESSION['user_id'], $requisId, $value); // Ajouter dans la table Profile
    }

    echo "<div class='alert alert-success text-center mt-4' style='background-color:#ffffff'>Profile updated successfully!</div>";
}
?>

<div class="container mt-5">
    <div class="m-3 mb-4">
        <h2 class="text-center" style="color: #3a6a40;">Fill Your Profile for an Offer</h2>
    </div>

    <form method="post" action="index.php?page=profileForm" class="shadow-lg p-4" style="background-color: #f1f8f3; border-radius: 8px;">
        <div class="mb-3">
            <label for="offer_id" class="form-label" style="color: #2b7a2b;">Select Offer</label>
            <select name="offer_id" id="offer_id" value="<?php echo $offerId ?>" class="form-select" required onchange="this.form.submit()">
                <option value="" disabled selected>Select an offer</option>
                <?php foreach ($offers as $offer): ?>
                    <option value="<?= htmlspecialchars($offer['offer_id']) ?>" <?= isset($offerId) && $offer['offer_id'] == $offerId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($offer['job_name']) ?> - Salary: <?= htmlspecialchars($offer['salaire']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if (!empty($requis)): ?>
            <div id="profileFields">
                <?php foreach ($requis as $requi): ?>
                    <div class="mb-3">
                        <label class="form-label" style="color: #17a2b8;"><?= htmlspecialchars($requi['nom']) ?>:</label>
                        <input type="text" name="profile_data[<?= $requi['id'] ?>]" class="form-control" required><br><br>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center">
                <input type="submit" value="Submit Profile" class="btn btn-success btn-lg highlight-btn">
            </div>
        <?php else: ?>
            <p>No requirements found for this offer.</p>
        <?php endif; ?>
    </form>
</div>

<!-- CSS pour ajouter du style aux boutons et champs -->
<style>
    .highlight-btn {
        transition: all 0.3s ease-in-out;
    }
    .highlight-btn:hover {
        transform: scale(1.05);
        /* box-shadow: 0 0 15px rgba(56, 189, 94, 0.5); Ombre verte légère */
        /* border-color: #3a6a40; Bordure légèrement plus sombre */
        /* background-color: #f1f8f3; Fond léger au survol */
    }
</style>

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
