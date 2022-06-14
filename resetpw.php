<?php

session_start();

require_once("./function.php");
require_once("./db.php");

date_default_timezone_set("Europe/Paris");

if (isset($_GET["token"]) && !empty($_GET["token"])) :
    $_SESSION['token'] = $_GET['token'];
endif;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require("./components/head.php"); ?>
    <title>Rénitialiser votre mot de passe - A.S. BEUVRY LA FORÊT</title>
</head>

<body>
    <!-- Bouton RETOUR -->
    <div class="return_container"><a href="./index.php"><i class="fas fa-arrow-left"></i>Retour</a></div>
    <!-- Fin bouton RETOUR -->
    <?php if (!isset($_GET["token"]) || empty($_GET["token"])) : ?>
        <section class="formulaire_login">
            <form method="POST" action="./functions/resetpw-sendmail.php" class="form_container">
                <div class="form_content">
                    <div class="logo_association"><img draggable="false" src="./public/images/logo-asb.svg" alt=""></div>
                    <h1>Réinitialisation du mot de passe</h1>
                    <p>Saisissez l'adresse e-mail associée à votre compte et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
                    <div class="mail">
                        <label for="mail" class="field_label_top">Adresse mail</label>
                        <input id="mail" type="email" pattern="[^ @]*@[^ @]*" placeholder="Adresse mail" name="email" autocomplete='on' <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
                        <div class="form_field_error_mail" <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="display: block" <?php endif; ?>><span role="alert"><?php display_flash_message_by_name(ERROR_MAIL); ?></span></div>
                    </div>
                    <div class="submit">
                        <button class="reverse" type="submit" name="submit">Réinitialiser</button>
                    </div>
                </div>
                <?php if (isset_flash_message_by_type(FLASH_SUCCESS)) { ?><p class='success'><?php display_flash_message_by_type(FLASH_SUCCESS); ?></p>
                <?php } else if (isset_flash_message_by_type(FLASH_WARNING)) { ?><p class='warning'><?php display_flash_message_by_type(FLASH_WARNING); ?></p><?php } ?>
            </form>
        </section>
    <?php else : ?>
        <section class="formulaire_login">
            <form method="POST" action="./functions/resetpw-changepw.php" class="form_container">
                <div class="form_content">
                    <div class="logo_association"><img draggable="false" src="./public/images/logo-asb.svg" alt=""></div>
                    <div class="mail">
                        <label for="mail" class="field_label_top">Adresse mail</label>
                        <input id="mail" type="email" pattern="[^ @]*@[^ @]*" placeholder="Adresse mail" name="email" autocomplete='on' <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
                        <div class="form_field_error_mail" <?php if (isset_flash_message_by_name(ERROR_MAIL)) : ?>style="display: block" <?php endif; ?>><span role="alert"><?php display_flash_message_by_name(ERROR_MAIL); ?></span></div>
                    </div>
                    <div class="password">
                        <label for="new_password" class="field_label_top">Nouveau mot de passe</label>
                        <input id="new_password" type="password" placeholder="Nouveau mot de passe" name="password" autocomplete='off' <?php if (isset_flash_message_by_name(ERROR_PSWD)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
                        <a href="#" role="button" class="view_password_link"><i class="fas fa-eye"></i></a>
                        <div class="form_field_error_password" <?php if (isset_flash_message_by_name(ERROR_PSWD)) : ?>style="display: block" <?php endif; ?>><span role="alert"><?php display_flash_message_by_name(ERROR_PSWD); ?></span></div>
                    </div>
                    <div class="password">
                        <label for="new_password_retype" class="field_label_top">Ressaisissez votre nouveau mot de passe</label>
                        <input id="new_password_retype" type="password" placeholder="Ressaisissez votre nouveau mot de passe" name="password_verif" autocomplete='off' <?php if (isset_flash_message_by_name(ERROR_SECOND_PSWD)) : ?>style="border-bottom: 2px solid rgb(210, 0, 0);" <?php endif; ?>>
                        <a href="#" role="button" class="view_password_link"><i class="fas fa-eye"></i></a>
                        <div class="form_field_error_password" <?php if (isset_flash_message_by_name(ERROR_SECOND_PSWD)) : ?>style="display: block" <?php endif; ?>><span role="alert"><?php display_flash_message_by_name(ERROR_SECOND_PSWD); ?></span></div>
                    </div>
                    <button type="submit" name="submit">Changer de mot de passe</button>
                </div>
                <?php if (isset_flash_message_by_type(FLASH_SUCCESS)) { ?><p class='success'><?php display_flash_message_by_type(FLASH_SUCCESS); ?></p>
                <?php } else if (isset_flash_message_by_type(FLASH_WARNING)) { ?><p class='warning'><?php display_flash_message_by_type(FLASH_WARNING); ?></p><?php } ?>
            </form>
        </section>
    <?php endif; ?>
    <script src="/public/js/login.js" type="text/javascript" async></script>
</body>

</html>