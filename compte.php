<?php
session_start();

require_once("./function.php");
require_once("./db.php");

if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "logout") {
    clean_php_session();
    header("location: index.php");
}

$settings = $db->query("SELECT color, logoPath FROM settings ORDER BY id DESC LIMIT 1");
$get_settings = $settings->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">

<head> <?php require("./components/head.php"); ?>
    <title>Mon compte - A.S. BEUVRY LA FORÊT</title>
</head>

<body>
    <?php if (is_logged()) : ?>
        <div class="content">
            <?php include('./components/header.php'); ?>
            <div class="container">
                <div class="container-content">
                    <?php include "./components/display_error.php"; ?>
                    <div class="account-container">
                        <div class="welcome-admin">
                            <h1>Bonjour <?= htmlspecialchars($_SESSION['prenom']); ?>,
                                <p>Tu es sur l'espace de gestion de compte</p>
                            </h1>
                        </div>
                        <div class="welcome-separator"></div>
                        <div class="account-panel">
                            <div class="account-li">
                                <ul>
                                    <li id="li-infos" onclick="displayContent('account-infos','account-settings','li-infos','li-settings')">
                                        <i class="fa fa-info"></i>
                                        <p>Mes informations</p>
                                    </li>
                                    <li id="li-settings" onclick="displayContent('account-settings','account-infos','li-settings','li-infos')"><i class="fa fa-cog"></i>
                                        <p>Mon association</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="account-li-content">
                                <div id="account-infos">
                                    <div class="site-settings-head">
                                        <h1>Mes informations</h1>
                                    </div>
                                    <?php if (is_admin()) : ?>
                                        <?php $account_info = $db->prepare("SELECT prenom, nom, mail, DCRE FROM admin WHERE idAdmin = ?;");
                                        $account_info->bindValue(1, $_SESSION["id"]);
                                        $account_info->execute();

                                        if ($account_info->rowCount() > 0) :
                                            $get_account_info = $account_info->fetch(PDO::FETCH_ASSOC); ?>

                                            <div class="info-settings-value">
                                                <p>Nom</p>
                                                <div class="info-settings-modif">
                                                    <p id="text1"><?= htmlspecialchars($get_account_info["nom"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["nom"]) ?>" id="inputText1" name="nom"></input>
                                                        <i onclick="displayInput(1)" id="pencil1" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate1"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Prénom</p>
                                                <div class="info-settings-modif">
                                                    <p id="text2"><?= htmlspecialchars($get_account_info["prenom"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["prenom"]) ?>" id="inputText2" name="prenom"></input>
                                                        <i onclick="displayInput(2)" id="pencil2" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate2"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Mail</p>
                                                <div class="info-settings-modif">
                                                    <p id="text3"><?= htmlspecialchars($get_account_info["mail"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["mail"]) ?>" id="inputText3" name="mail"></input>
                                                        <i onclick="displayInput(3)" id="pencil3" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate3"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Mot de passe</p>
                                                <div class="info-settings-modif">
                                                    <p>••••••••</p>
                                                    <a href="./resetpw.php">
                                                        <i id="pencil2" class="fa fa-pencil"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="info-settings-value site-settings-footer">
                                                <p>Date de création</p>
                                                <p><?= date('d-m-Y', strtotime($get_account_info["DCRE"])); ?></p>
                                            </div>

                                        <?php endif; ?>
                                    <?php elseif (is_educ()) : ?>
                                        <?php $account_info = $db->prepare("SELECT prenom, nom, mail, responsable, DCRE FROM educ WHERE idEduc = ?;");
                                        $account_info->bindValue(1, $_SESSION["id"]);
                                        $account_info->execute();

                                        if ($account_info->rowCount() > 0) :
                                            $get_account_info = $account_info->fetch(PDO::FETCH_ASSOC); ?>
                                            <div class="info-settings-value">
                                                <p>Nom</p>
                                                <div class="info-settings-modif">
                                                    <p id="text1"><?= htmlspecialchars($get_account_info["nom"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["nom"]) ?>" id="inputText1" name="nom"></input>
                                                        <i onclick="displayInput(1)" id="pencil1" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate1"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Prénom</p>
                                                <div class="info-settings-modif">
                                                    <p id="text2"><?= htmlspecialchars($get_account_info["prenom"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["prenom"]) ?>" id="inputText2" name="prenom"></input>
                                                        <i onclick="displayInput(2)" id="pencil2" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate2"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Mot de passe</p>
                                                <div class="info-settings-modif">
                                                    <p>••••••••</p>
                                                    <a href="./resetpw.php">
                                                        <i id="pencil2" class="fa fa-pencil"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="info-settings-value">
                                                <p>Mail</p>
                                                <div class="info-settings-modif">
                                                    <p id="text3"><?= htmlspecialchars($get_account_info["mail"]) ?></p>
                                                    <form action="./functions/settings-modif-info.php" method="POST">
                                                        <input type="hidden" value="<?= $_SESSION["id"] ?>" name="id">
                                                        <input type="text" value="<?= htmlspecialchars($get_account_info["mail"]) ?>" id="inputText3" name="mail"></input>
                                                        <i onclick="displayInput(3)" id="pencil3" class="fa fa-pencil"></i>
                                                        <button type="submit" onclick="form.submit()" id="validate3"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </div>
                                            </div>

                                            <?php $account_categorie = $db->prepare("SELECT nomCategorie FROM categorie INNER JOIN categorieeduc ON categorie.idCategorie = categorieeduc.idCategorie WHERE idEduc = ?; ");
                                            $account_categorie->bindValue(1, $_SESSION["id"]);
                                            $account_categorie->execute();

                                            if ($account_categorie->rowCount() > 0) : ?>
                                                <div class="info-settings-value">
                                                    <p>Categorie</p>
                                                    <p>
                                                        <?php $get_account_categorie = $account_categorie->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($get_account_categorie as $categorie) :
                                                            if (end($get_account_categorie)["nomCategorie"] == $categorie["nomCategorie"]) :
                                                                echo $categorie["nomCategorie"];
                                                            else :
                                                                echo $categorie["nomCategorie"];
                                                                echo ", ";
                                                            endif;
                                                        endforeach;
                                                        ?>
                                                    </p>
                                                </div>
                                            <?php else : ?>
                                                <div class="info-settings-value">
                                                    <p>Categorie</p>
                                                    <p>Aucune catégorie</p>
                                                </div>
                                            <?php endif; ?>
                                            <div class="info-settings-value">
                                                <p>Responsable</p>
                                                <p><?php if ($get_account_info["responsable"] == 1) {
                                                        echo "OUI";
                                                    } else {
                                                        echo "NON";
                                                    } ?>
                                                </p>
                                            </div>
                                            <div class="info-settings-value site-settings-footer">
                                                <p>Date de création</p>
                                                <p><?php echo date('d-m-Y', strtotime($get_account_info["DCRE"])); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div id="account-settings">
                                    <?php if ($settings) : ?>
                                        <div class="site-settings">
                                            <div class="site-settings-tab1">
                                                <div class="site-settings-head">
                                                    <h1>Informations de l'association</h1>
                                                </div>
                                                <div class="site-settings-name">
                                                    <p>Nom de l'association</p>
                                                    <p>AS BEUVRY-LA-FORÊT</p>
                                                </div>
                                                <div class="site-settings-logo">
                                                    <p>Logo du site</p>
                                                    <img src="<?= $get_settings["logoPath"] ?>" class="img">
                                                </div>
                                                <div class="site-settings-color">
                                                    <p>Couleur principale</p>
                                                    <span class="color"></span>
                                                </div>
                                            </div>
                                            <?php if (is_admin()) : ?>
                                                <div class="site-settings-tab2">
                                                    <div class="site-settings-head">
                                                        <h1>Modification des informations</h1>
                                                    </div>
                                                    <form action="./functions/settings-modif.php" class="modif-settings" method="POST" enctype="multipart/form-data">
                                                        <div class="site-settings-logo">
                                                            <div class="site-settings-logo1">
                                                                <p>Nouveau logo</p>
                                                            </div>
                                                            <div class="site-settings-logo2">
                                                                <label for="site-logo">
                                                                    <i class="fa fa-upload"></i>
                                                                    <input id="site-logo" type="file" accept="image/png, image/jpeg" name="logo" value="<?= $get_settings['logoPath'] ?>">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="site-settings-color">
                                                            <p>Nouvelle couleur</p>
                                                            <input id="site-color" type="color" name="color" value="<?= $get_settings['color'] ?>">
                                                        </div>
                                                        <div class="site-settings-save">
                                                            <input type="submit" name="submit-settings" value="Modifier">
                                                        </div>
                                                    </form>
                                                </div>
                                                <form action="./functions/settings-cancel-modif.php" class="cancel-settings" method="POST">
                                                    <input type="submit" name="cancel-settings" value="Annuler les modifications">
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function displayInput(index) {
                document.getElementById('inputText' + index).style.display = "block";
                document.getElementById('pencil' + index).style.display = "none";
                document.getElementById('validate' + index).style.display = "block";
                document.getElementById('text' + index).style.display = "none";
            }

            let input1 = document.getElementById('inputText1');
            input1.addEventListener('input', resizeInput);
            let input2 = document.getElementById('inputText2');
            input2.addEventListener('input', resizeInput);
            let input3 = document.getElementById('inputText3');
            input3.addEventListener('input', resizeInput);
            if (input1) {
                resizeInput.call(input1);
            }
            if (input2) {
                resizeInput.call(input2);
            }
            if (input3) {
                resizeInput.call(input3);
            }

            function resizeInput() {
                let inputValue = this.value.length;
                this.style.width = (inputValue + 2) + "ch";
            }
        </script>
        <script>
            function displayContent(idActive, idOther1, idList, idListOther1) {
                document.getElementById(idActive).style.display = "flex";
                document.getElementById(idList).style.background = "var(--mainColor)";
                document.getElementById(idList).style.color = "white";
                document.getElementById(idOther1).style.display = "none";
                document.getElementById(idListOther1).style.background = "white";
                document.getElementById(idListOther1).style.color = "black";
            }
        </script>
        <?php require 'components/footer.php'; ?>
    <?php else : require "./components/form_login.php";
    endif; ?>
</body>

</html>