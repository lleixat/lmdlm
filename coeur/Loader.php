<?php

class Loader {

    public $request;
    private $error;

    function __construct() {
        $this->request = new Request();
        $this->dispatcher();
    }

    /**
     * Permet de gerer ce qui va etre chargé ou non
     */
    function dispatcher() {
        switch ($this->request->request_type) {
            case "statique":
                // on appelle juste la page statique demandée
                $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
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
                        $this->affiche_erreur();
                        return false;
                    }
                }
                break;
            case "action":
                // on va charger dynamiquement le controller qui correspond
                // et lui lancer la methode (action) demandée en lui donnant
                // comme arguments request->params qui contient les parametres
                // post et get (dans ce case précis)
                // nom du controller
                $name = ucfirst($this->request->controller) . "Controller";
                // fichier physique
                $file = CONTROLLER . DS . $name . ".php";
                // existe t il
                if (file_exists($file)) {
                    require CONTROLLER . DS . "Controller.php";
                    require $file;
                    $obj = new $name;
                    // la methode souhaitée existe t elle
                    if (method_exists($obj, $this->request->action)) {
                        // on lance la methode de cet objet dynamique
                        call_user_func_array(array($obj, $this->request->action), $this->request->params);
                    } else {
                        // methode inexistante
                        $this->error = "La méthode '<b>{$this->request->action}</b>' n'existe pas dans l'objet {$name}().";
                        $this->affiche_erreur();
                    }
                } else {
                    // fichier du controller inexistant
                    $this->error = "Le fichier {$file} n'existe pas";
                    $this->affiche_erreur();
                }

                print_r($this->request);
                break;
            case "full_action":
                break;
        }
    }

    /**
     * Charge un controlleur dynamiquement
     * @param string $c nom du controlleur a charger
     * @return bool booléen qui valide ou non le chargement de l'objet
     */
    function charge_controlleur($c) {

    }

    /**
     * Place un texte d'erreur dans l'attribut qui va bien
     * @param string $txt texte d'erreur
     */
    function set_error($txt) {
        $this->error = $txt;
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

}

?>
