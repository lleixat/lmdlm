<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo URL_BASE; ?>" />
        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/text.css" />
        <link rel="stylesheet" media="screen" href="css/grid.css" />

        <script src="js/jquery-1.6.4.min.js"></script>

        <link href="favicon.png" rel="shortcut icon" />

        <meta name="description" content="<?php echo DESCRIPTION ?>">
     </head>
    <body>
        <div id="conteneur">
            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
            <h2>Espace personnel</h2>
                <div class="column1">
                    <h3>Le mot du jour</h3>
                    <div>
                        <?php
                        echo $this->contenu['phrase'];
                        ?>
                    </div>
                </div>
                <div class="column2">
                    <h3>Historique</h3>
                    <ul class="histo">
                        <?php
                        echo $this->contenu['histo'];
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
