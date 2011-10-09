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
            @import url(http://fonts.googleapis.com/css?family=Schoolbell);
            span.phrase{
                font-size: 0.9em;
                display: block;
                padding: 10px;
                background-color: #297DA9;
                margin: 10px;
            }
            div.bigbig{
                font-family: 'Schoolbell', cursive;
                font-size: 2.5em;
                text-align: center;
                font-weight: bold;
            }
            span.lmdlm{
                font-weight: bold;
                color: #00ffff;
            }
            img.capture{
                display: block;
                margin: auto;
                border: 10px solid #ADE0E0;
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
                <h1 class="titre_page">Administration</h1>    

                <?php
                echo $this->contenu['html'];
                ?>
            </div>
            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>