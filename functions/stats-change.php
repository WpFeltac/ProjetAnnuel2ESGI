<?php

session_start();

require_once("../function.php");
require_once("../db.php");

date_default_timezone_set("Europe/Paris");


//verification si l'utilisateur est connecté
if (is_logged()) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_GET["idStat"]) && !empty($_GET["idStat"])) {
            $idStat = $_GET["idStat"];
            if (filter_var($idStat, FILTER_VALIDATE_INT)) {
                //recuperer les infos utilisateeurs via idStat
                $getInfo = $db->query("SELECT licencie.prenom FROM licencie INNER JOIN statistiques ON licencie.idLicencie = statistiques.idLicencie WHERE statistiques.idStat = $idStat");
                $info = $getInfo->fetch(PDO::FETCH_ASSOC);
                if (isset($_POST['add-goal'])) {
                    // ajouter un but;
                    $req = $db->query("UPDATE statistiques SET nbButs = nbButs + 1 WHERE idStat = $idStat");
                    if ($req) {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                        } else {
                            header("location: ../statistiques.php");
                        }
                        create_flash_message("change-success", "Vous venez d'ajouter un but à " . $info['prenom'] . ".", FLASH_SUCCESS);
                        exit();
                    }
                } elseif (isset($_POST['remove-goal'])) {
                    // supprimer un but;
                    $req = $db->query("UPDATE statistiques SET nbButs = nbButs - 1 WHERE idStat = $idStat");
                    if ($req) {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                        } else {
                            header("location: ../statistiques.php");
                        }
                        create_flash_message("change-success", "Vous venez de retirer un but à " . $info['prenom'] . ".", FLASH_SUCCESS);
                        exit();
                    }
                } elseif (isset($_POST['add-pd'])) {
                    // ajouter une passe décisvies
                    $req = $db->query("UPDATE statistiques SET passeD = passeD + 1 WHERE idStat = $idStat");
                    if ($req) {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                        } else {
                            header("location: ../statistiques.php");
                        }
                        create_flash_message("change-success", "Vous venez d'ajouter une passe dé à " . $info['prenom'] . ".", FLASH_SUCCESS);
                        exit();
                    }
                } elseif (isset($_POST['remove-pd'])) {
                    // supprimer une passe décisives
                    $req = $db->query("UPDATE statistiques SET passeD = passeD - 1 WHERE idStat = $idStat");
                    if ($req) {
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                        } else {
                            header("location: ../statistiques.php");
                        }
                        create_flash_message("change-success", "Vous venez de retirer une passe dé à " . $info['prenom'] . ".", FLASH_SUCCESS);
                        exit();
                    }
                } else {
                    header("location: ../statistiques.php");
                    create_flash_message("submit-error", "Une erreur est survenue, Veuillez réessayer.", FLASH_ERROR);
                    exit();
                }
            } else {
                create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
                header("location: ../statistiques.php");
                exit();
            }
        } else {
            create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
            header("location: ../statistiques.php");
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
