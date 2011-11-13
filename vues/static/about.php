<?php 
error_reporting(E_ALL);
?>


<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo URL_BASE; ?>" />
        <meta name="description" content="<?php echo DESCRIPTION ?>">
        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/text.css" />
        <link rel="stylesheet" media="screen" href="css/grid.css" />

        <link href="favicon.png" rel="shortcut icon" />

        <script src="js/jquery-1.6.4.min.js"></script>


    </head>
    <body>

        <div id="conteneur">

            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h2 class="titre_page">Bienvenue !</h2>
                <p>Le <b>Mot de la Mort</b> est le service expérimental et sans prétention qui
                    s'adresse aux étudiants, comme nous, qui souhaitent ajouter
                    un peu de <b>fun</b> là où le formalisme et de mise. Le
                    <b>Mot de la Mort</b> n'est qu'un <b>jeu</b> de Mots (donc), autant
                    vous dire que la première règle est de ne pas se prendre au
                    sérieux. Pour autant nous avons apporté (et continuons), le plus
                    de précision et de sérieux possible à la construction de ce service.
                </p>
                <h3>WTF ?</h3>
                <p>L'idée a germée comme une évidence sur un réseau social, où nous
                    avons pris l'habitude d'imposer chaque semaine un mot
                    improbable à chacun des étudiants participants.<br />
                    Ce mot en tête, le jeu consistait à le placer dans une phrase
                    sur le forum de notre promotion (Unilim[DEUST]).<br />
                    L'idée a aujourd'hui fait sont chemin, ainsi nous avons entreprit
                    de proposer une plateforme succincte (mais réelle!) d'abord pour
                    répondre à un besoin (un lieu unique pour comptabiliser ; gérer ; lister ... ),
                    puis surtout pour le <b>fun d'y mettre les mains</b>, et puis pourquoi
                    pas, si vous correspondez aux critères... nous recrutons des dev ;
                    intégrateurs ; designers ; whatever ... juniors avec de bonnes
                    idées et/ou suggestions pour améliorer le système. ;)
                </p>
                <p>
                    Quoi qu'il en soit, vous êtes tous en droit de nous dire qu'on à fait de la merde
                    (ça nous arrive aussi hein ?) par mail ou direct en face (c'est mieux ^^).<br />
                    En revanche vous êtes dans l'obligation d'apporter une solution en retours
                    (bein ouais, quand même...). Et si vous êtes courageux vous avez aussi
                    la possibilité d'apporter votre contribution en
                    <a href="https://github.com/rudak/lmdlm">forkant le projet sur github</a>
                    et en ajoutant votre pierre à l'édifice !  
                </p>
                <p>
                    Alors plus d'excuses ! Viendez joué avec nous !
                </p>
                <div id="contact">
                    <ul class="embed_block">Contacts on github only :

                        <li><a href="https://github.com/rudak/lmdlm">rudak</a></li>
                        <li><a href="https://github.com/lleixat/lmdlm">l3x</a></li>
                    </ul>
                </div>
            </div>

            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
