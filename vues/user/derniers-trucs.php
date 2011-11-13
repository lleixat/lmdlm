<?php
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
                <h2>Salut <a href="user_pageMembre/<?php echo User::$id; ?>/user_<?php echo User::$user_url; ?>.html"><?php echo User::$user; ?></a> !</h2>
                <h3>Quoi de neuf ?</h3>
                    <p>Heummm... il semblerai que ce soit bogué ce truc là... (<u>todo:</u> fixer le refresh du 'last' dans la base.)</p>
                <div class="column1">
                    <h4>Membres inscrits</h4>
                    <p>Liste des membres inscrits durant votre absence.</p>
                    <?php
                    echo $contenu['dmInsc'];
                    ?>

                </div>
                <div class="column2">
                    <h4>Mots validés</h4>
                    <p>Liste des mots que vous avez proposés et ayant été validés pour le jeu.</p>
                    <?php
                    echo $contenu['dmVal'];
                    ?>

                </div>
            </div>


            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
