<?php
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

    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_USER_BAR;
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h1>yeaahhh <?php echo User::$user; ?> !</h1>
                <div class="cadre_bleu radius10">
                <h4>Inscription : ok !</h4>
                <p>Un mail de validation de ton adresse email (<b><?php echo User::$mail; ?></b>) vient de t'être envoyé, clique simplement sur le lien qu'il contient <u>dans les 24 heures</u> pour valider ton compte ou il sera supprimmé.</p>
                <p>Merci l'ami, amuse toi bien !</p>
                </div>
            </div>


            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
