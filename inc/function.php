<?php 
    require_once "./static/constant.php";

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


    function repartitionHeureSup($heure){
        $valiny = [];
        if($heure<=8) return $valiny['first'] = $heure;

        $valiny["first"] = 8;
        $valiny["last"] = $heure - 8;
        return $valiny;
    }





?>