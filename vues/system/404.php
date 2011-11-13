<?php
header("HTTP/1.0 404 Not Found");
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <base href="<?php echo URL_BASE; ?>" />
        <meta charset="UTF-8">

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
                <h2 class="titre_page">Erreur 404</h2>
                <p>Il n'y a rien à voir ici ..!</p>
                    <?php
                    if(isset($phrase)){
                        echo "<h3>Indication dev</h3>";
                        echo "<p>{$phrase}</p>";
                    }
                ?>
                <p>
                    <a class="back" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">← Retour</a>
                </p>

            </div>

            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>
