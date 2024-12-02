<?php
    require_once './inc/static/constant.php';
    include 'header.php';

    $emp_id = $_GET['id'];
    $date = $_GET['date'];
    // mois et employer id mila jerenaa

    const devise = "AR";
    // info base avy any am base
  

    $employe = $user->getEmployeInfo($emp_id);
    

    $tauxJournalier = ceil(getTauxJournalier($employe['salaire']));
    $tauxHoraire = ceil(getTauxHoraire($employe['salaire']));

    // Mois et ID employé
    $mois = '2024-11'; // Mois de novembre 2024
    $employe_id = 1; // ID de l'employé
    
    $heures_supplementaires = $user->getHeuresSupParSemaine($date,$emp_id);


    // requete any am base
    // $heures_supplementaires = [
    //     [
    //         'employe_id' => $employe_id,
    //         'semaine_debut' => "$mois-01", // Début de la semaine
    //         'heures' => 8, // Heures supplémentaires statiques pour cette semaine
    //     ],
    //     [
    //         'employe_id' => $employe_id,
    //         'semaine_debut' => "$mois-06",
    //         'heures' => 10,
    //     ],
    //     [
    //         'employe_id' => $employe_id,
    //         'semaine_debut' => "$mois-13",
    //         'heures' => 15,
    //     ],
    //     [
    //         'employe_id' => $employe_id,
    //         'semaine_debut' => "$mois-20",
    //         'heures' => 7,
    //     ],
    //     [
    //         'employe_id' => $employe_id,
    //         'semaine_debut' => "$mois-27",
    //         'heures' => 12,
    //     ],
    // ];

    $heureSup = calculerTotaux($heures_supplementaires);
    
    // requete any am base sisa

    $heure_special = $user->getHeuresSpecialesParMois($mois,$emp_id);
    // $heure_special = [];
    // $heure_special[1] = [
    //     'type_jour' => 1,
    //     'total_heures' => 12
    // ];

    // $heure_special[2] = [
    //     'type_jour' => 2,
    //     'total_heures' => 8
    // ];

    // donnée

    // Calcul des composantes
    $salaireDeBase = round($tauxJournalier * 30); // Salaire de base pour 30 jours travaillés
    $heureSup30 = $tauxHoraire * HEURE_SUP_8_FIRST * $heureSup['first'];
    $heureSup40 = $tauxHoraire * HEURE_SUP_12_LAST * $heureSup['last'];
    $heureDimanche = $tauxHoraire * HEURE_DIMANCHE * $heure_special[1]['total_heures'];
    $heureFerie = $tauxHoraire * JOUR_FERIE * $heure_special[2]['total_heures'];
    $primePerformance = 200;
    $indemniteTransport = 50;

    // Calcul du salaire brut
    $salaireBrut = $salaireDeBase 
        + $heureSup30 
        + $heureSup40 
        + $heureDimanche 
        + $heureFerie 
        + $primePerformance 
        + $indemniteTransport;

    // Retenue salarial
    $retenuCnaps = (RETENUE_CNAPS($salaireBrut));
    $retenuSanitaire = (RETENUE_SANITAIRE($salaireBrut));

    // IRSA
    $totalIRSA = calculIRSA($salaireBrut);
    $retenuTotal = $retenuCnaps + $retenuSanitaire + $totalIRSA;


    //total revenue
    $net_payer = $salaireBrut - $retenuTotal;

?>

    <style>
        .fiche-paie {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="container fiche-paie">
    <h2 class="text-center pb-4" >Fiche de Paie</h2>
    <!-- Informations Générales -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Nom et Prénom :</strong> <?= $employe['nom'] ?></p>
            <p><strong>ID :</strong> <?= $employe['id'] ?> </p>
            <p><strong>Fonction :</strong> <?= $employe['job'] ?></p>
            <p><strong>Date d'Embauche :</strong> <?= $employe['dt_embauche'] ?></p>
            <p><strong>Ancienneté :</strong> <?= $employe['anciennete']?></p>
        </div>
        <div class="col-md-6">
            <p><strong>Salaire de Base :</strong> <?= $employe['salaire'].devise ?></p>
            <p><strong>Taux Journalier :</strong> <?= $tauxJournalier.devise ?></p>
            <p><strong>Taux Horaire :</strong> <?= $tauxHoraire.devise ?></p>
        </div>
    </div>

    <!-- Tableau des Détails -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Designation</th>
                <th>Nombre</th>
                <th>Taux</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de Base</td>
                <td>30</td>
                <td><?= $tauxJournalier ?></td>
                <td><?= $salaireDeBase  ?></td>
            </tr>
            <!-- <tr>
                <td>Prime de Performance</td>
                <td>1</td>
                <td>200 EUR</td>
                <td>200 EUR</td>
            </tr>
            <tr>
                <td>Indemnité Transport</td>
                <td>1</td>
                <td>50 EUR</td>
                <td>50 EUR</td>
            </tr> -->
            <tr>
                <td>Heure supplémentaire majoré 30%</td>
                <td><?= $heureSup['first'] ?></td>
                <td><?= round($tauxHoraire * HEURE_SUP_8_FIRST); ?></td>
                <td><?= $heureSup30; ?></td>
            </tr>
            <tr>
                <td>Heure supplémentaire majoré 40%</td>
                <td><?= $heureSup['last'] ?></td>
                <td><?= round($tauxHoraire * HEURE_SUP_12_LAST); ?></td>
                <td><?= $heureSup40; ?></td>
            </tr>
            <tr>
                <td>Heure supplémentaire majoré 50%</td>
                <td><?= $heure_special[1]['total_heures'] ?></td>
                <td><?= round($tauxHoraire * HEURE_DIMANCHE); ?></td>
                <td><?= $heureDimanche ?> </td>
            </tr>
            <tr>
                <td>Heure supplémentaire majoré 100%</td>
                <td><?= $heure_special[2]['total_heures'] ?></td>
                <td><?= round($tauxHoraire * JOUR_FERIE); ?></td>
                <td><?= $heureFerie ?> </td>
            </tr>
            <!-- Totaux -->
            <tr class="total">
                <td colspan="3">Total Salaire Brut</td>
                <td><?=  $salaireBrut ?></td>
            </tr>

            <!-- Calcul cnaps -->
            <tr class="total">
                <td colspan="3">Retenue CNAPS (1%)</td>
                <td><?= -$retenuCnaps ?> </td>
            </tr>
            <tr class="total">
                <td colspan="3">Retenue Sanitaire</td>
                <td><?= -$retenuSanitaire ?></td>
            </tr>
            <tr>
                <td>Tranche IRSA INF 350 0000</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
    <td>Tranche IRSA DE 350 001 à 400 000</td>
    <td></td>
    <td><?= htmlspecialchars(IRSA_350k_400k_STR) . "%" ?></td>
    <td>
        <?php 
        if ($salaireBrut > 350000): 
            echo -IRSA_350k_400k; 
        else: 
            echo 0; 
        endif; 
        ?>
    </td>
</tr>
<tr>
    <td>Tranche IRSA DE 400 001 à 500 000</td>
    <td></td>
    <td><?= htmlspecialchars(IRSA_400k_500k_STR) . "%" ?></td>
    <td>
        <?php 
        if ($salaireBrut > 400000): 
            echo -IRSA_400k_500k; 
        else: 
            echo 0; 
        endif; 
        ?>
    </td>
</tr>
<tr>
    <td>Tranche IRSA DE 500 001 à 600 000</td>
    <td></td>
    <td><?= htmlspecialchars(IRSA_500k_600k_STR) . "%" ?></td>
    <td>
        <?php 
        if ($salaireBrut > 500000): 
            echo -IRSA_500k_600k; 
        else: 
            echo 0; 
        endif; 
        ?>
    </td>
</tr>
<tr>
    <td>Tranche IRSA SUP 600 000</td>
    <td></td>
    <td><?= htmlspecialchars(IRSA_SUP_600k_STR) . "%" ?></td>
    <td>
        <?php 
        if ($salaireBrut > 600000): 
            echo -(IRSA_SUP_600k($salaireBrut)); 
        else: 
            echo 0; 
        endif; 
        ?>
    </td>
</tr>


            <tr class="total">
                <td colspan="3">Tranches IRSA</td>
                <td><?= -($totalIRSA) ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Total Retenues</td>
                <td><?= -($retenuTotal) ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Net à Payer</td>
                <td><?= $net_payer ?></td>
            </tr>
        </tbody>
    </table>
</div>
<button onclick="exportFichePaiePDF()" class="btn btn-primary">Exporter en PDF</button>

<script>
    async function exportFichePaiePDF() {
        // Import jsPDF
        const { jsPDF } = window.jspdf;

        // Créer une instance de jsPDF
        const pdf = new jsPDF('p', 'mm', 'a4'); // Mode portrait, unité en mm, format A4

        // Sélectionner l'élément HTML de la fiche de paie
        const fichePaieElement = document.querySelector('.fiche-paie');

        // Convertir l'élément HTML en image via html2canvas
        await html2canvas(fichePaieElement, {
            scale: 2, // Augmenter la résolution
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png'); // Convertir en base64
            const pageWidth = pdf.internal.pageSize.getWidth(); // Largeur de la page PDF
            const pageHeight = (canvas.height * pageWidth) / canvas.width; // Ajuster la hauteur

            // Ajouter l'image à la page PDF
            pdf.addImage(imgData, 'PNG', 0, 0, pageWidth, pageHeight);

            // Sauvegarder le PDF
            pdf.save('fiche_de_paie.pdf');
        }).catch(error => {
            console.error('Erreur lors de la génération du PDF :', error);
            alert('Une erreur est survenue lors de la génération du PDF.');
        });
    }
</script>

