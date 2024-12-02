<?php 
    // salaire de base
    function getTauxJournalier($salaireBase){
        return $salaireBase/30;
    }

    function getTauxHoraire($salaireBase){
        return $salaireBase/173.33;
    }





    // heure sup multiplicateur
    const HEURE_SUP_8_FIRST = 1.3;
    const HEURE_SUP_12_LAST = 1.4;

    const HEURE_DIMANCHE = 1.5;
    const JOUR_FERIE = 2;

    const HEURE_NUIT = 1.3;

    
    function salaireHeureSup_8_FIRST($tauxHoraire,$heureSup){
        return $tauxHoraire * HEURE_SUP_8_FIRST * $heureSup;
    }

    function salaireHeureSup_12_LAST($tauxHoraire,$heureSup){
        return $tauxHoraire * HEURE_SUP_12_LAST * $heureSup;
    }

    function salaireHeureSup_DIMANCHE($tauxHoraire,$heureSup){
        return $tauxHoraire * HEURE_DIMANCHE * $heureSup;
    }

    function salaireHeureSup_FERIE($tauxHoraire,$heureSup){
        return $tauxHoraire * JOUR_FERIE * $heureSup;
    }

    function salaireHeure_NUIT($tauxHoraire,$heureSup){
        return $tauxHoraire * HEURE_NUIT * $heureSup;
    }
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
            $repartition = repartitionHeureSup($heure_supp['total_heures']);
            $totaux['first'] += $repartition['first'];
            $totaux['last'] += $repartition['last'];
        }
        return $totaux;
    }

    // IRSA

    const IRSA_350k_400k_STR =  5;
    const IRSA_400k_500k_STR = 10;
    const IRSA_500k_600k_STR = 15;
    const IRSA_SUP_600k_STR = 20;

    const IRSA_350k_400k = (50000 * 5)/100;
    const IRSA_400k_500k = (100000 * 10)/100;
    const IRSA_500k_600k = (100000 * 15)/100;

    function IRSA_SUP_600k($vola){
        return (($vola - 600000)*20)/100;
    }


    function calculIRSA($salaireBrut){
        $irsa = 0;

        if($salaireBrut <= 350000) return $irsa;
        // Tranche 350k-400k
        if ($salaireBrut > 350000)  $irsa += IRSA_350k_400k;
        // Tranche 400k-500k
        if ($salaireBrut > 400000)  $irsa += IRSA_400k_500k;
        // Tranche 500k-600k
        if ($salaireBrut > 500000)  $irsa += IRSA_500k_600k;
        // Tranche > 600k
        if ($salaireBrut > 600000) $irsa += IRSA_SUP_600k($salaireBrut);

        return $irsa;
    }

    // Retenue salariale
    function RETENUE_CNAPS($salaireBrut){
        $retenueCnaps = $salaireBrut/100;
        if($retenueCnaps > 20000) return 20000;
        return $retenueCnaps;
    }

    function RETENUE_SANITAIRE($salaireBrut){
        return $salaireBrut/100;
    }

    // absence
    function Abscence_Deductible($tauxHoraire, $heure){
        return ($tauxHoraire * $heure) * -1;
    }



?>