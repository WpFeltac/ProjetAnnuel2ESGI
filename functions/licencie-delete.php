<?php

session_start();

require_once("../function.php");
require_once("../db.php");


if (is_logged()) {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET["idLicencie"]) && !empty($_GET["idLicencie"])) {
            $idLicencie = $_GET["idLicencie"];
            if (filter_var($idLicencie, FILTER_VALIDATE_INT)) {
                $info = $db->prepare("SELECT licencie.nom, licencie.prenom FROM licencie WHERE licencie.idLicencie = $idLicencie");
                $req = $db->prepare("BEGIN; UPDATE licencie SET licencie.COSU = 1 WHERE licencie.idLicencie = ?; UPDATE cotis SET cotis.COSU = 1 WHERE cotis.idLicencie = ?; UPDATE statistiques SET statistiques.COSU = 1 WHERE statistiques.idLicencie = ?;COMMIT;");
                $req->bindValue(1, $idLicencie, PDO::PARAM_INT);
                $req->bindValue(2, $idLicencie, PDO::PARAM_INT);
                $req->bindValue(3, $idLicencie, PDO::PARAM_INT);
                $info->execute();
                $result = $req->execute();
                $getinfo = $info->fetch(PDO::FETCH_ASSOC);
                $firstname_licencie = $getinfo["prenom"];
                $lastname_licencie = $getinfo["nom"];

                if ($result) {
                    create_flash_message("delete_success", "Le licencié « $lastname_licencie $firstname_licencie » a bien été supprimé.", FLASH_SUCCESS);
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                    } else {
                        header("location: ../licencies.php");
                    }
                    exit();
                } else {
                    create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                    } else {
                        header("location: ../licencies.php");
                    }
                    exit();
                }
            } else {
                create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
                } else {
                    header("location: ../licencies.php");
                }
                exit();
            }
        } else {
            create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("location:" . $_SERVER['HTTP_REFERER']); //L'adresse de la page qui a conduit le client à la page courante
            } else {
                header("location: ../licencies.php");
            }
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
