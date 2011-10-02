<?php
// header("HTTP/1.0 404 Not Found");
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
                <h1 class="titre_page">Erreur SYSTEME</h1>
                <p>Il y a une couille dans le script ca arrive vu qu'on est des deustiens !</p>
                    <?php
                    if(isset($phrase)){
                        echo "<h3>Indication dev</h3>";
                        echo "<p>{$phrase}</p>";
                    }
                    if(isset($debug)){
                        $this->prp($debug);
                    }
                    ?>
            </din>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>