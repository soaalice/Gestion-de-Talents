<?php 

    // pourcentage heure sup
    const HEURE_SUP_8_FIRST = 30;
    const HEURE_SUP_12_LAST = 40;

    const HEURE_DIMANCHE = 50;
    const JOUR_FERIE = 100;

    const HEURE_NUIT = 30;

    // IRSA

    const IRSA_350k_400k = (50000 * 5)/100;
    const IRSA_400k_500k = (100000 * 10)/100;
    const IRSA_500k_600k = (100000 * 15)/100;

    function IRSA_SUP_600k($vola){
        return (($vola - 600000)*20)/100;
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

?>