<?php 
    require_once "./inc/static/constant.php";

    $tauxHoraire = 24000;
    $salaireBase = 4089409.09;

    // Mois et ID employé
    $mois = '2024-11'; // Mois de novembre 2024
    $employe_id = 1; // ID de l'employé

    // Définir les valeurs fixes pour chaque semaine
    $heures_supplementaires = [
        [
            'employe_id' => $employe_id,
            'semaine_debut' => "$mois-01", // Début de la semaine
            'heures' => 8, // Heures supplémentaires statiques pour cette semaine
        ],
        [
            'employe_id' => $employe_id,
            'semaine_debut' => "$mois-06",
            'heures' => 10,
        ],
        [
            'employe_id' => $employe_id,
            'semaine_debut' => "$mois-13",
            'heures' => 15,
        ],
        [
            'employe_id' => $employe_id,
            'semaine_debut' => "$mois-20",
            'heures' => 7,
        ],
        [
            'employe_id' => $employe_id,
            'semaine_debut' => "$mois-27",
            'heures' => 12,
        ],
    ];

    // Fonction pour répartir les heures supplémentaires
    function repartitionHeureSup($heure) {
        $valiny = [];
        if ($heure <= 8) {
            $valiny['first'] = $heure;
            $valiny['last'] = 0;
            return $valiny;
        }
        $valiny['first'] = 8;
        $valiny['last'] = $heure - 8;
        return $valiny;
    }

    // Fonction pour calculer les totaux des "first" et "last"
    function calculerTotaux($heures_supplementaires) {
        $totaux = ['first' => 0, 'last' => 0]; // Initialiser les totaux

        foreach ($heures_supplementaires as $heure_supp) {
            $repartition = repartitionHeureSup($heure_supp['heures']);
            $totaux['first'] += $repartition['first'];
            $totaux['last'] += $repartition['last'];
        }

        return $totaux;
    }

    // Calcul des totaux
    $totaux = calculerTotaux($heures_supplementaires);

    // Affichage des totaux
    echo "<h3>Totaux des Heures Supplémentaires</h3>";
    echo "Total des 8 premières heures : " . $totaux['first'] . " heures, heure sup: ".$tauxHoraire * HEURE_SUP_8_FIRST."<br>";
    echo "Total des heures restantes : " . $totaux['last'] . " heures, heure sup ".$tauxHoraire * HEURE_SUP_12_LAST."<br>";

    // Afficher les heures supplémentaires et leur répartition
    echo "<table border='1'>";
    echo "<tr><th>Semaine Début</th><th>Heures Totales</th><th>8 Premières Heures</th><th>Restantes</th></tr>";

    foreach ($heures_supplementaires as $heure_supp) {
        $repartition = repartitionHeureSup($heure_supp['heures']); // Répartition des heures
        echo "<tr>";
        echo "<td>" . $heure_supp['semaine_debut'] . "</td>";
        echo "<td>" . $heure_supp['heures'] . "</td>";
        echo "<td>" . $repartition['first'] . "</td>";
        echo "<td>" . $repartition['last'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "IRSA :" .calculIRSA($salaireBase);
?>
