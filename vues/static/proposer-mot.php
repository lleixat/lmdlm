<?php
$pm_jeton = md5(CLE_SHA_PERSO . time() . rand(0, 15));
$_SESSION['jeton_prop_mot'] = $pm_jeton;

$c = $this->contenu['liste_mots_user'];
?>
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
                width: 250px;
                text-align: right;
                font-weight: bold;
            }
            div.cadre_bleu p img{
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
                <h1 class="titre_page">proposer un mot</h1>
                <div class="cadre_bleu radius10" >
                    <form action="mot_proposer/proposer-mot.html" enctype="multipart/form-data" 
                          method="post" id="pm_form">
                        <p>
                            <input type="hidden" name="pm_jeton" value="<?php echo $pm_jeton; ?>" />
                            <label for="pm_mot">Quel mot souhaitez vous proposer ?</label><br />
                            <input type="text" name="pm_mot" id="pm_mot" /><br />
                            <input type="submit" value="Proposer !" />
                        </p>
                    </form>
                </div>
                <?php
                echo $c;
                ?>


            </div>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>