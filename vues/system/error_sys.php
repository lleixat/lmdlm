<?php
// header("HTTP/1.0 404 Not Found");
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

        <meta name="description" content="<?php echo DESCRIPTION ?>">
    </head>
    <body>
        <div id="conteneur">
            <?php
            //require LAYOUT_HEADER;
            //require LAYOUT_NAV;
            ?>

            <div id="content" style="margin-top: 100px;">
                <h2>Erreur SYSTEME</h2>
                <p><b>Il y a une couille dans le script ça arrive vu qu'on est des deustiens !</b></p>
                    <?php
                    if(isset($phrase)){
                        echo "<h4>Indication dev</h4>";
                        echo "<p>{$phrase}</p>";
                    }
                    if(isset($debug)){
                        $this->prp($debug);
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
