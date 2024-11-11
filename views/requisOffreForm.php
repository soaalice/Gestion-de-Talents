<?php
// Récupérer les offres disponibles pour le recruteur
$offers = $user->getRecruiterOffers($_SESSION['user_id']);

// Récupérer tous les requis avec leur type
$requis = $user->getRequis();

// Gestion du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire
    $offerId = $_POST['offer_id'];
    $requisId = $_POST['requis_id'];
    $minimum = $_POST['minimum'];
    $maximum = $_POST['maximum'];

    // Insérer les requis pour l'offre dans la base de données
    if ($user->createRequisOffre($offerId, $requisId, $minimum, $maximum)) {
        echo "<p>Requisite successfully added to the offer!</p>";
    } else {
        echo "<p>Failed to add requisite.</p>";
    }
}
?>

<h2>Add Requirements to an Offer</h2>
<form method="post" action="index.php?page=requisOffreForm">
    <label>Offer:</label><br>
    <select name="offer_id" required>
        <?php foreach ($offers as $offer): ?>
            <option value="<?= htmlspecialchars($offer['offer_id']) ?>">
                <?= htmlspecialchars($offer['job_name']) ?> - Salary: <?= htmlspecialchars($offer['salaire']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Requirement:</label><br>
    <select name="requis_id" id="requis_id" required onchange="updateInputType()">
        <?php foreach ($requis as $requi): ?>
            <option value="<?= htmlspecialchars($requi['id']) ?>" data-type="<?= htmlspecialchars($requi['type_name']) ?>">
                <?= htmlspecialchars($requi['nom']) ?> <!-- Afficher le nom du requis -->
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Minimum Value:</label><br>
    <input type="text" id="minimum" name="minimum" required><br><br>

    <label>Maximum Value:</label><br>
    <input type="text" id="maximum" name="maximum" required><br><br>

    <input type="submit" value="Add Requirement">
</form>

<script>
    // Fonction pour mettre à jour le type des inputs minimum et maximum en fonction du TypeChamp
    function updateInputType() {
        const selectedRequis = document.getElementById("requis_id");
        const requisType = selectedRequis.options[selectedRequis.selectedIndex].dataset.type;

        // Adapter le type d'input en fonction du TypeChamp
        switch (requisType) {
            case "varchar":
                document.getElementById("minimum").type = "text";
                document.getElementById("maximum").type = "text";
                break;
            case "int":
                document.getElementById("minimum").type = "number";
                document.getElementById("maximum").type = "number";
                break;
            case "decimal":
                document.getElementById("minimum").type = "number";
                document.getElementById("minimum").step = "0.01";  // pour les décimaux
                document.getElementById("maximum").type = "number";
                document.getElementById("maximum").step = "0.01";  // pour les décimaux
                break;
            case "date":
                document.getElementById("minimum").type = "date";
                document.getElementById("maximum").type = "date";
                break;
            case "timestamp":
                document.getElementById("minimum").type = "datetime-local";
                document.getElementById("maximum").type = "datetime-local";
                break;
            case "boolean":
                document.getElementById("minimum").type = "checkbox";
                document.getElementById("maximum").type = "checkbox";
                break;
            default:
                document.getElementById("minimum").type = "text";
                document.getElementById("maximum").type = "text";
                break;
        }
    }

    // Initialiser le formulaire avec le bon type de champ dès le début
    updateInputType();
</script>