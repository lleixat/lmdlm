<?php

class Request {

    public $request_type;
    public $controller;
    public $action;
    public $dossier;
    public $vue;
    public $referer;
    public $params = array();

    function __construct() {


        $path_info = (isset($_SERVER['PATH_INFO'])) ? trim($_SERVER['PATH_INFO'], "/") : false;

        // si y a pas de path_info c'est qu'on est a la racine
        // donc on redirige vers l'accueil
        if (!$path_info) {
            header('Location:accueil.html');
            exit();
        }


        // on INVERSE le tableau contenant la découpe de l'url
        $parts = array_reverse(explode('/', $path_info));

        // Dossier & Page
        if (isset($parts[0])) {
            $this->href = $parts[0];
            $tab_temp = explode("_", trim($parts[0], "_"));
            $this->dossier = (count($tab_temp) == 2) ? $tab_temp[0] : "static";
            $this->vue = (count($tab_temp) == 2) ? $tab_temp[1] : $tab_temp[0];
        }

        // le type de requete (format d'URL)
        switch (count($parts)) {


            case 1:
                // pas d'action ni de parametres
                // ex URL : http://www.lejeudelamort.com/accueil.html
                $this->request_type = "statique";
                break;


            case 2:
                // action et page mais pas de parametres
                // ex URL : http://www.lejeudelamort.com/user_add/accueil.html
                $this->request_type = "action";

                // Controlleur & Action
                if (isset($parts[1])) {
                    $tab_temp = explode("_", trim($parts[1], "_"));
                    $this->controller = (isset($tab_temp[0])) ? $tab_temp[0] : false;
                    $this->action = (isset($tab_temp[1])) ? $tab_temp[1] : false;
                }
                break;


            case 3:
                //  action param et page
                // ex URL : http://www.lejeudelamort.com/blog_liste/12_88_1/accueil.html
                $this->request_type = "full_action";


                // Parametres
                if (isset($parts[1])) {
                    $this->params = explode("_", trim($parts[1], "_"));
                } else {
                    $this->params = "";
                }

                // Controlleur & Action
                if (isset($parts[2])) {
                    $tab_temp = explode("_", trim($parts[2], "_"));
                    $this->controller = (isset($tab_temp[0])) ? $tab_temp[0] : false;
                    $this->action = (isset($tab_temp[1])) ? $tab_temp[1] : false;
                }


                break;
        }

        // $_POST
        if (isset($_POST) && count($_POST) > 0) {
            $this->params['post'] = $_POST;
        }

        // $_FILES
        if(isset($_FILES) && count($_FILES) > 0){
            $this->params['files'] = $_FILES;
        }

        $this->referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null;
    }

    function set_request_type($txt) {
        $this->request_type = $txt;
    }

}

?>
