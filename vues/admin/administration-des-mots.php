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
            span.mot{
                display: inline-block;
                width: 200px;
                text-align: right;
                font-weight: bold;
            }
            #liste p{
                margin: 0;
            }
            #liste a{
                text-decoration: none;
                color: #97E0D9;
            }
            p:hover{
                background-color:#07628F;
            }
            #liste img{
                vertical-align: middle;
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
                <h1 class="titre_page">Administration des mots</h1>
                <div class="cadre_bleu radius10" id="liste">
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