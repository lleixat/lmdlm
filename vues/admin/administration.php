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


        <link rel="stylesheet" media="screen" href="css/text.css" />
        <link rel="stylesheet" media="screen" href="css/grid.css" />

        <link href="favicon.png" rel="shortcut icon" />

        <script src="js/jquery-1.6.4.min.js"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">
    </head>
    <body>
        <div id="conteneur">
        <?php
        require LAYOUT_HEADER;
        require LAYOUT_NAV;
        ?>

            <div id="content">
                <h2>Administration</h2>
                <div>
                    <ul class="embed_block">
                        <li>
                            <a href="admin_resultatsMdlm/admin_resultats-mdlm.html">Gestion des résultats quotidiens <?php echo $txt_res_attente; ?></a>
                        </li>
                        <li>
                            <a href="admin_valideMots/administration-des-mots.php">Gestion des mots</a>
                        </li>
                        <li>
                            <a href="admin_gererMembres/administration-des-membres.html">Gestion des utilisateurs</a>
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
