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
            span.pseudo{
                display: inline-block;
                width: 200px;
                text-align: right;
            }
            span.niveau{
                display: inline-block;
                width: 140px;
                text-align: center;
            }
            .pair,.impair{
                margin: 0 auto;
            }
            .pair{
                background-color: #2584B0;
            }
            .impair{
                background-color: #2481AC;
            }
            .titre{
                font-weight: bold;
                font-size: 1.1em;
                padding: 10px 0;
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
                <h2>Gestion des membres</h2>
                <div class="cadre_bleu radius10">
                    <div style="width: 550px;margin: auto; border: 1px solid #31A0D3;" >
                        <?php
                        echo $this->contenu['html'];
                        ?>    
                    </div>
                </div>

            </div>
            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>