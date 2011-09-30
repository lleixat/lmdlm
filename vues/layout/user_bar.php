<div id="user_bar">
    <?php
    if (isset($contenu)) {
        if ($contenu['logged']) {
            echo $contenu['ub_texte'];
        } else {
            echo $contenu['ub_form'];
        }
    }
    ?>

</div>