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

        <script type="text/javascript">

            $(document).ready(function(){
                $('.wrap').hide();

                $('.clickme').click(function() {
                    var block=$(this).parent().next();

                    if (block.css('display')=='none') {
                        block.slideDown('slow').show();
                       
                    } else {
                        block.slideUp('slow');
                    }

                });
            });

        </script>

    </head>
    <body>
        <div id="conteneur">
            <?php
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <?php echo $contenu['histo'] ?>
            </div>


            <?php
            require LAYOUT_FOOTER;

            ?>
        </div>
    </body>
</html>