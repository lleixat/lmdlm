<?php
header("HTTP/1.0 404 Not Found");
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <base href="<?php echo URL_BASE; ?>" />
        <meta charset="UTF-8">

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

            <din id="content">
                <h1 class="titre_page">Erreur 404</h1>
                <p>Il n'y a rien a voir ici ..!</p>
                    <?php
                    if(isset($phrase)){
                        echo "<h3>Indication dev</h3>";
                        echo "<p>{$phrase}</p>";
                    }
                    ?>
            </din>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>