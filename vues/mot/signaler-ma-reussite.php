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
            textarea{
                width: 600px;
                height: 60px;
                padding: 10px;
                resize : none;
                color: #ADE0E0;
                background-color: #056DA0;
                border: none;
                margin: auto;
                display: block;
            }
            div.bigbig{
                font-family: 'Schoolbell', cursive;
                font-size: 2.5em;
                text-align: center;
                font-weight: bold;
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
                <h1 class="titre_page">Vous avez réussi ?</h1>
                <div class="cadre_bleu radius10">
                    
                    <?php
                    echo $this->contenu['phrase'];
                    echo $this->contenu['form'];
                    ?>


                </div>
            </div>
            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>