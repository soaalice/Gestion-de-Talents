<?php
header('Content-Type: text/html; charset=UTF-8');

class Constante
{
public static function id_licenciement(){
    return 1;
}
public static function id_demission(){
    return 2;
}
public static function id_actif(){
    return 1;
}
public static function id_resilie(){
    return 2;
}
public static function id_en_cours(){
    return 1;
}
public static function id_non_respecter(){
    return 2;
}
public static function id_terminer(){
    return 3;
}
public static function id_en_attente(){
    return 1;
}
public static function id_regle(){
    return 2;
}
public static function date_fin($dates){
    $date = new DateTime($dates);
    $date->modify("+1 month");
    return $date->format("Y-m-d");
}

}
