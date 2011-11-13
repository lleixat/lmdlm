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
        <div id="conteneur">
            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h2 class="titre_page">Proposer un mot</h2>
                <p>Cette page permet de proposer un mot qui sera (<b>après validation</b>),
                    ajouté à la liste des mots disponibles pour le jeu.</p>
                <div class="column1" >
                        <?php echo $this->contenu['html_prop_mot']; ?>
                    <h3><?php echo $this->contenu['liste_mots_user']['title']; ?></h3>    
                    <ul><?php echo $this->contenu['liste_mots_user']['list']; ?></ul>
                </div>
                <div class="column2">
                    <h3>Tous les mots déjà proposés</h3>
                    <ul><?php echo $this->contenu['liste_tous_mots']; ?></ul>
                </div>
<!-- <div id="yep">
<p class="green">( OK )</p>
<p class="yellow">( ! )</p>
<p class="red">( X )</p>

</div> -->
            </div>

            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
