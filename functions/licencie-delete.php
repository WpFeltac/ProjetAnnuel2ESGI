<?php

session_start();

require_once("../function.php");
require_once("../db.php");


if (isset($_GET["idLicencie"]) && !empty($_GET["idLicencie"])) {
    $idLicencie = $_GET["idLicencie"];
    if (filter_var($idLicencie, FILTER_VALIDATE_INT)) {
        $req = $db->prepare("BEGIN; UPDATE licencie SET licencie.COSU = 1 WHERE licencie.idLicencie = ?; UPDATE cotis SET cotis.COSU = 1 WHERE cotis.idLicencie = ?; COMMIT;");
        $req->bindValue(1, $idLicencie, PDO::PARAM_INT);
        $req->bindValue(2, $idLicencie, PDO::PARAM_INT);
        $result = $req->execute();

        if ($result) {
            create_flash_message("delete_success", "Le licencié a bien été supprimé.", FLASH_SUCCESS);
            header("location: ../licencies.php");
            exit();
        } else {
            create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
            header("location: ../licencies.php");
            exit();
        }
    } else {
        create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
        header("location: ../licencies.php");
        exit();
    }
} else {
    create_flash_message("delete_error", "Une erreur est survenue. Veuillez réessayer.", FLASH_ERROR);
    header("location: ../licencies.php");
    exit();
}