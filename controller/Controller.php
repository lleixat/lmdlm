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

    function __construct($request = false) {
        if (!isset($this->request) && $request !== false) {
            $this->request = $request;
        }
    }

    /**
     * Methode qui permet d'afficher une vue demandée
     *
     * @param string $file fichier correspondant a la vue qu'on souhaite afficher
     * @return bool Retourne true si ca marche et false sinon.
     */
    function afficher_vue($file) {
        
        // si le gars est banni
        if ($this->verif_ban()) {
            $file = VUES . DS . 'static' . DS . 'banni.php';
            require $file;
        } else {
            $contenu = $this->contenu;
            if (file_exists($file)) {
                require $file;

                return true;
            } else {
                // on tente avec ".php" si le fichier ".html" n'est pas existant
                $file_html = str_replace(".html", ".php", $file);

                if (file_exists($file_html)) {
                    require $file_html;

                    return true;
                } else {
                    $this->set_error("La vue {$file} n'existe pas.");
                    $this->affiche_erreur(PAGE_404);

                    return false;
                }
            }
        }
    }

    function affiche_erreur($page = ERROR_SYS, $debug=false) {


        $contenu = $this->contenu;
        // gestion du probleme
        if (MODE == "dev") {
            $phrase = $this->error;
            require $page;
        } else {
            require $page;
        }
    }

    function set_error($txt) {
        $this->error = $txt;
    }

    function formatteDate($t) {
        /**
         *      renvoie une date en fonction d'aujourd'hui
         *      Hier, avant hier, le 14/04/1984
         */
        $minuit = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $minuit_hier = $minuit - (3600 * 24);
        if ($t >= $minuit) {
            $date = "aujourd'hui à " . date("H:i", $t);
        } else if ($t >= $minuit_hier) {
            $date = "hier à " . date("H:i", $t);
        } else {
            $date = "le " . date("d/m/Y \à H:i", $t);
        };
        return $date;
    }

    function formatrewriting($chaine) {
        //les accents
        $chaine = trim($chaine);
        $chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        //les caracètres spéciaux (aures que lettres et chiffres en fait)
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        $chaine = trim($chaine, "-");
        return $chaine;
    }

    function prp($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    function verif_ban() {
        // si le gars est banni on le redirige
        if (User::$rang === '0'){            
            return true;
        }  else {
            return false;
        }
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
 *
 */
?>
