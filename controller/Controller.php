<?php

/**
 * Le papa des controlleurs qui contien toutes les methodes récurentes
 * comme l'affichage de la vue qui devrait etre contenu dans toutes les
 * classes enfants sinon
 *
 * @author rudak
 */
class Controller {


    function afficher_vue() {

    }

    function prp($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

?>
