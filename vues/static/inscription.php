<?php

?>
<?php ?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/general.css" />
        <link rel="stylesheet" media="screen" href="css/trick.css" />
        <script src="js/jquery-1.6.4.min.js"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">
    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_USER_BAR;
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <din id="content">
                <h1 class="titre_page">Inscription</h1>
                <p>Creer formulaire simple pour inscription</p>
            </din>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>