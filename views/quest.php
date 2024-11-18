<?php
include "header.php";
// Charger les données JSON
$questionsData = json_decode(file_get_contents('./assets/data/questions.json'), true);

// Générer la liste des thèmes
$themes = array_keys($questionsData);
?>
<script>
    // Transférer les questions de PHP à JavaScript
    const questionsData = <?php echo json_encode($questionsData); ?>;
</script>
<div class="row mt-5">
    <div class="col-8 offset-2 text-center text-success">
        <h1>QCM Dynamique</h1>
    </div>
</div>

<div class="container">
    <!-- Sélection du thème -->
    <div class="mb-3">
        <label for="theme-select" class="form-label">Choisissez un thème :</label>
        <select id="theme-select" class="form-select">
            <option value="" disabled selected>Sélectionnez un thème</option>
            <?php foreach ($themes as $theme): ?>
                <option value="<?php echo $theme; ?>"><?php echo ucfirst($theme); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Conteneur des questions -->
    <div id="question-container" class="mt-4 hidden"></div>

    <!-- Bouton pour soumettre les réponses -->
    <!-- <div class="row">
        <div class="col-12 my-3">
            <button class="btn btn-primary" id="submit-answers">Recommencer</button>
        </div>
    </div> -->
</div>

<script src="./assets/data/script.js" defer></script>
<style>
    . {
        font-family: Arial, sans-serif;
    }

    #question-container {
        margin-top: 20px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .hidden {
        display: none;
    }
    .container {
        min-height: 30%;
    }

    footer {
        display: flex;
        /* bottom: 0;
        z-index: 9;
        position: absolute; */
    }
</style>