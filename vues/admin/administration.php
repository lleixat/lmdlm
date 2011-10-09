<?php
require MODEL . DS . 'AdminModel.php';
$am = new AdminModel();
$nb = $am->nombre_de_validation_en_attente();
$txt_res_attente = ($nb > 0) ? "({$nb} en attente)" : "";
?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo URL_BASE; ?>" />
        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/general.css" />
        <link rel="stylesheet" media="screen" href="css/trick.css" />
        <script src="js/jquery-1.6.4.min.js"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">
        <style type="text/css">
            ul{
                list-style: none;
                padding: 0px;
            }
            ul a{
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div id="conteneur" class="ombre10">
        <?php
        require LAYOUT_USER_BAR;
        require LAYOUT_HEADER;
        require LAYOUT_NAV;
        ?>

            <div id="content">
                <h1>Admnistration</h1>
                <div class="cadre_bleu radius10">
                    <ul>
                        <li>
                            <a href="admin_resultatsMdlm/admin_resultats-mdlm.html" class="bouton radius5">Administration des résultats quotidiens <?php echo $txt_res_attente; ?></a>
                        </li>
                        <li>
                            <a href="#" class="bouton radius5">Administration des mots</a>
                        </li>
                        <li>
                            <a href="#" class="bouton radius5">Administration des utilisateurs</a>
                        </li>
                    </ul>
                </div>

            </div>




<?php
require LAYOUT_FOOTER;
?>
        </div>
    </body>
</html>