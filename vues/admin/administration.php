
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
                <ul>
                    <li><a href="admin_resultatsMdlm/admin_resultats-mdlm.html">
                            Administration des résultats quotidiens</a></li>
                    <li><a href="#">Administration des mots</a></li>
                    <li><a href="#">Administration des utilisateurs</a></li>                    
                </ul>

            </div>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>