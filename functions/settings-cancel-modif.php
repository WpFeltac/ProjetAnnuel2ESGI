<?php

session_start();

require_once("../function.php");
require_once("../db.php");

date_default_timezone_set("Europe/Paris");

//verification si l'utilisateur est connecté
if (is_logged()) {
    $get_all_settings = $db->query("SELECT id FROM settings");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['cancel-settings'])) {
            if ($get_all_settings->rowCount() > 1) {
                //supprimer les anciennes données 
                $result = $db->query("DELETE FROM settings ORDER BY id DESC LIMIT 1");
                if ($result) {
                    header("location: ../compte.php");
                    create_flash_message("req-success", "La modification a bien été annulée.", FLASH_SUCCESS);
                    exit();
                } else {
                    header("location: ../compte.php");
                    create_flash_message("submit-error", "Une erreur est survenue, Veuillez réessayer.", FLASH_ERROR);
                    exit();
                }
            } else {
                header("location: ../compte.php");
                create_flash_message("cancel-error", "Impossible de revenir en arrière.", FLASH_ERROR);
                exit();
            }
        } else {
            header("location: ../compte.php");
            create_flash_message("submit-error", "Une erreur est survenue, Veuillez réessayer.", FLASH_ERROR);
            exit();
        }
    } else {
        header("location: ../index.php");
        exit();
    }
} else {
    header("location: ../index.php");
    exit();
}
