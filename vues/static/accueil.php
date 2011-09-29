<?php ?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/general.css" />
        <link rel="stylesheet" media="screen" href="css/trick.css" />
        <script src="js/script.js"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">
    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_HEADER;

            require LAYOUT_NAV;
            ?>

            <din id="content">
                <h1 style="margin-top: 5px;">Page d'accueil</h1>
            </din>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>