<?php
?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo URL_BASE; ?>" />
        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/text.css" />
        <link rel="stylesheet" media="screen" href="css/grid.css" />

        <link href="favicon.png" rel="shortcut icon" />

        <script src="js/jquery-1.6.4.min.js"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">

    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h2>yeaahhh <?php echo User::$user; ?> !</h2>
                <div>
                <h4>Inscription : ok !</h4>
                <p>Un mail de validation vient de t'être envoyé à l'adresse que tu as renseigné.<br />
<br />
                    Clique simplement sur le lien qu'il contient <u>dans les 24 heures</u> pour valider ton compte automatiquement. Dans le cas contraire, ta demande d'inscription sera mise en attente et tu devras demander l'intervention d'un admin pour valider ton compte.</p><p>Voilà !</p>
                <p>Merci l'ami, amuse toi bien !</p>
                </div>
            </div>


            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
