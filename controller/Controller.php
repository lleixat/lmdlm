<?php

/**
 * Le papa des controlleurs qui contien toutes les methodes récurentes
 * comme l'affichage de la vue qui devrait etre contenu dans toutes les
 * classes enfants sinon
 *
 * @author rudak
 */
class Controller {

    protected $contenu = array();
    protected $error;

    function __construct($request) {
        $this->request = $request;
    }

    /**
     * Methode qui permet d'afficher une vue demandée
     *
     * @param string $file fichier correspondant a la vue qu'on souhaite afficher
     * @return bool Retourne true si ca marche et false sinon.
     */
    function afficher_vue($file) {
        if (file_exists($file)) {

            require $file;
            return true;
        } else {

            // on tente avec ".php" si le fichier ".html" n'est pas existant
            // (
            $file_html = str_replace(".html", ".php", $file);
            if (file_exists($file_html)) {
                require $file_html;
                return true;
            } else {

                $this->set_error("La vue {$file} n'existe pas.");
                $this->affiche_erreur();
                return false;
            }
        }
    }

    function affiche_erreur() {
        // gestion du probleme
        if (MODE == "dev") {
            $phrase = $this->error;
            require PAGE_404;
        } else {
            require PAGE_404;
        }
    }

    function prp($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

/*
 *
 * BUGs A FIXER
 *
 * dans afficher_vue()
 * pouvoir réellement permuter les extensions et non pas remplacer .html par .php
 * (si c un fichier .php on ne remplacera rien sinon)
 * ligne 34 en principe
 *
 * affiche erreur()
 * pouvoir passer en argument le type de page d'erreur a afficher
 * page404 ou page erreur simple ou page erreur systeme
 * rapidement avant d'avoir trop d'appels a modifier un peu partout
 * et risquer d'en oublier..
 *
 *
 */
?>
