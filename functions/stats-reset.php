<?php

session_start();

require_once("../function.php");
require_once("../db.php");

date_default_timezone_set("Europe/Paris");


//verification si l'utilisateur est connecté
if (is_logged()) {
    if (is_admin() || is_educ()) { //verification si il a les droits

        //reinitialiser tous les buts et les passeD pour 0
        $req = $db->query("UPDATE statistiques SET nbButs = 0, passeD = 0;");
        if ($req) {
            create_flash_message("success-reset", "Les statistiques ont bien été reinitialisées.", FLASH_SUCCESS);
            header("location: ../statistiques.php");
            exit();
        }
    } else {
        create_flash_message("no_rights", "Vous ne possédez pas les droits.", FLASH_ERROR); //the user is not admin 
        header("location: ../statistiques.php");
        exit();
    }
} else {
    header("location: ../index.php");
    exit();
}
