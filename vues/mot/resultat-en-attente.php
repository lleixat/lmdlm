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
        <style type="text/css">

        </style>
    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h2 class="titre_page">Votre saisie est en attente de validation...</h2>
                <div>                    
                    <?php
                    ?>
                    <p class="embed_block">Vous venez de valider votre performance, elle a bien été prise en compte 
                        et sera vérifiée très vite par un gentil <b>validateur</b>.<br /><br />
                        A bientôt !  :)
                    </p>
                </div>
            </div>
            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
