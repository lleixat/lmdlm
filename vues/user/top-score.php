<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo URL_BASE; ?>" />
        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/text.css" />
        <link rel="stylesheet" media="screen" href="css/grid.css" />

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
                <h2>Top score</h2>
                <div class="embed_block">
                    <?php
                    echo $this->contenu['liste'];
                    ?>
                </div>
            </div>


            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>

