<?php

session_start();

require_once("../function.php");
require_once("../db.php");

date_default_timezone_set("Europe/Paris");

if (is_logged()) {
    if (isset($_POST["submit-modif"])) {
        if (isset($_POST["nom-licencie"]) && !empty($_POST["nom-licencie"])) {
            if (isset($_POST["prenom-licencie"]) && !empty($_POST["prenom-licencie"])) {
                if (isset($_POST["dateN-licencie"]) && !empty($_POST["dateN-licencie"])) {
                    if (isset($_POST["categorie-licencie"]) && !empty($_POST["categorie-licencie"])) {
                        if (isset($_POST["sexe-licencie"]) && !empty($_POST["sexe-licencie"])) {
                            if (isset($_POST["idLicencie"]) && !empty($_POST["idLicencie"])) {
                                if (isset($_POST["mail-licencie"]) && !empty($_POST["mail-licencie"]) && filter_var($_POST["mail-licencie"], FILTER_VALIDATE_EMAIL)) {
                                    $nom_licencie = strtoupper($_POST["nom-licencie"]);
                                    $prenom_licencie = ucfirst($_POST["prenom-licencie"]);
                                    $dateN_licencie = $_POST["dateN-licencie"];
                                    $mail_licencie = $_POST["mail-licencie"];
                                    $categorie_licencie = $_POST["categorie-licencie"];
                                    $sexe_licencie = $_POST["sexe-licencie"];
                                    $current_user = $_SESSION["prenom"] . " " . strtoupper($_SESSION["nom"]);
                                    $current_date = date("Y-m-d H:i:s");
                                    $idLicencie = $_POST["idLicencie"];
                                    $req = $db->prepare("UPDATE licencie SET prenom = :prenom, nom = :nom, sexe = :sexe, dateN = :dateN, mail = :mail, idCategorie = :idCategorie, DMAJ = :DMAJ WHERE idLicencie = :idLicencie");
                                    $req->bindValue("prenom", $prenom_licencie, PDO::PARAM_STR);
                                    $req->bindValue("nom", $nom_licencie, PDO::PARAM_STR);
                                    $req->bindValue("sexe", $sexe_licencie, PDO::PARAM_STR);
                                    $req->bindValue("dateN", $dateN_licencie, PDO::PARAM_STR);
                                    $req->bindValue("mail", $mail_licencie, PDO::PARAM_STR);
                                    $req->bindValue("idCategorie", $categorie_licencie, PDO::PARAM_INT);
                                    $req->bindValue("DMAJ", $current_date);
                                    $req->bindValue("idLicencie", $idLicencie);
                                    $result = $req->execute();

                                    if ($result) {
                                        header("location: ../licencies.php");
                                        create_flash_message("modif_success", "Licencié modifié", FLASH_SUCCESS);
                                        exit();
                                    } else {
                                        header("location: ../licencies.php");
                                        create_flash_message("modif_error", "Une erreur est survenue, Veuillez réessayer.", FLASH_ERROR);
                                        exit();
                                    }
                                } else {
                                    header("location: ../licencies.php");
                                    create_flash_message("form_mail_error", "Email invalide.", FLASH_ERROR);
                                    exit();
                                }
                            } else {
                                header("location: ../licencies.php");
                                create_flash_message("form_id_error", "Veuillez remplir tous les champs", FLASH_ERROR);
                                exit();
                            }
                        } else {
                            header("location: ../licencies.php");
                            create_flash_message("form_sexe_error", "Veuillez remplir tous les champs", FLASH_ERROR);
                            exit();
                        }
                    } else {
                        header("location: ../licencies.php");
                        create_flash_message("form_categorie_error", "Veuillez remplir tous les champs", FLASH_ERROR);
                        exit();
                    }
                } else {
                    header("location: ../licencies.php");
                    create_flash_message("form_dateN_error", "Veuillez remplir tous les champs", FLASH_ERROR);
                    exit();
                }
            } else {
                header("location: ../licencies.php");
                create_flash_message("form_firstname_error", "Veuillez remplir tous les champs", FLASH_ERROR);
                exit();
            }
        } else {
            header("location: ../licencies.php");
            create_flash_message("form_lastname_error", "Veuillez remplir tous les champs", FLASH_ERROR);
            exit();
        }
    } else {
        header("location: ../modif-licencie.php");
        create_flash_message("modif_error", "Une erreur est survenue, Veuillez réessayer.", FLASH_ERROR);
        exit();
    }
} else {
    header("location: ../index.php");
    exit();
}