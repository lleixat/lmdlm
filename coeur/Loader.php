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
                // on instancie le controller papa et on appelle la page statique voulue
                $file = VUES .  DS . $this->request->dossier . DS . $this->request->vue;
                $controller = new Controller($this->request);

                $controller->afficher_vue($file);
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

                    require $file;
                    $obj = new $name($this->request);
                    // la methode souhaitée existe t elle
                    if (method_exists($obj, $this->request->action)) {
                        // on lance la methode de cet objet dynamique
                        $array_param = (is_array($this->request->params)) ? $this->request->params : array();

                        call_user_func_array(array($obj, $this->request->action), $array_param);
                    } else {
                        // methode inexistante
                        $this->error = "La méthode '<b>{$this->request->action}</b>()' n'existe pas dans l'objet '<b>{$name}()</b>'.";
                        $this->affiche_erreur(ERROR_SYS);
                    }
                } else {
                    // fichier du controller inexistant
                    $this->error = "Le fichier {$file} n'existe pas";
                    $this->affiche_erreur(ERROR_SYS);
                }

                break;
            case "full_action":
                $this->error = "FULL ACTION => pas encore cod&eacute; .. ca va vite venir !!  =)";
                $this->affiche_erreur(ERROR_SYS);
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

    /*
     * initialise le controller et le charge de gerer l'erreur
     */
    function affiche_erreur($page) {
        $controller = new Controller($this->request);
        $controller->set_error($this->error);
        $controller->affiche_erreur($page);
   }

}

?>
