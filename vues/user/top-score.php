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
            span.user{
                display: inline-block;
                text-align: right;
                width: 200px;
            }
            a.lien_user{
                  text-align: right;
                font-weight: bold;
                color: #ADE0E0;
                text-decoration: none;
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
                <h1>Top score</h1>
                <div class="cadre_bleu radius10">
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

