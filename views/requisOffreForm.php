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
        echo "<div class='alert alert-success text-center mt-4'>Requisite successfully added to the offer!</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Failed to add requisite.</div>";
    }
}
include 'header.php';
?>

<div class="container mt-5">
    <div class="m-3 mb-4">
        <h2 class="text-center" style="color: #3a6a40;">Add Requirements to an Offer</h2>
    </div>
    <form method="post" action="index.php?page=requisOffreForm" class="shadow-lg p-4" style="background-color: #f1f8f3; border-radius: 8px;">
        <div class="mb-3">
            <label for="offer_id" class="form-label" style="color: #2b7a2b;">Offer</label>
            <select name="offer_id" id="offer_id" class="form-select" required>
                <?php foreach ($offers as $offer): ?>
                    <option value="<?= htmlspecialchars($offer['offer_id']) ?>">
                        <?= htmlspecialchars($offer['job_name']) ?> - Salary: <?= htmlspecialchars($offer['salaire']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="requis_id" class="form-label" style="color: #17a2b8;">Requirement</label>
            <select name="requis_id" id="requis_id" class="form-select" required onchange="updateInputType()">
                <?php foreach ($requis as $requi): ?>
                    <option value="<?= htmlspecialchars($requi['id']) ?>" data-type="<?= htmlspecialchars($requi['type_name']) ?>">
                        <?= htmlspecialchars($requi['nom']) ?> <!-- Afficher le nom du requis -->
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="minimum" class="form-label" style="color: #17a2b8;">Minimum Value</label>
            <input type="text" id="minimum" name="minimum" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="maximum" class="form-label" style="color: #17a2b8;">Maximum Value</label>
            <input type="text" id="maximum" name="maximum" class="form-control" required>
        </div>

        <div class="text-center">
            <input type="submit" value="Add Requirement" class="btn btn-warning btn-lg highlight-btn">
        </div>
    </form>
</div>

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

<!-- CSS pour personnaliser les boutons et les champs de formulaire -->
<style>
    .highlight-btn {
        transition: all 0.3s ease-in-out;
    }

    .highlight-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(56, 189, 94, 0.5); /* Ombre verte légère */
        border-color: #3a6a40; /* Bordure légèrement plus sombre */
    }

    .form-select, .form-control {
        background-color: #eaf4e0; /* Fond naturel clair */
        border-color: #c5e1c5; /* Bordure douce */
    }

    .form-select:focus, .form-control:focus {
        border-color: #3a6a40; /* Bordure verte plus foncée lors de la sélection */
        box-shadow: 0 0 5px rgba(56, 189, 94, 0.5);
    }
</style>
