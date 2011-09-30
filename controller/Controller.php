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
        $this->setUserBar();
    }

    function setUserBar() {
        // le gars est til connecté
        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
            // oui alors on cree un objet user
            $oUser = new User($_SESSION['id_user']);
            $html = "<p>Connecté en tant que ";
            $html .= "<a href='user_page-perso/{$oUser->getId()}/user_page-perso.html' class='ub_liens'>{$oUser->getUser()}</a> ";
            $html .= "<a href='user_deco/accueil.html' class='ub_liens' style='margin-left:20px'>Deconnexion</a></p>";
            $this->contenu['ub_texte'] = $html;
            $this->contenu['logged'] = true;
        } elseif($this->request->request_type == "statique" || $this->request->request_type == "error"){
            // Seulement si le gars n'est pas connecté et que nous allons vers une page statique
            $jeton = md5(sha1(CLE_SHA_PERSO . time() . rand(0, 15)));
            $_SESSION['jeton'] = $jeton;
            $this->contenu['ub_form'] =
                "<form action='user_login/accueil.php' method='post' id='forum_ub'>
                    <p>
                        <input type='hidden' name='ub_jeton' value='{$jeton}' />
                        <label for='ub_user'>User : </label>
                        <input type='text' name='ub_user' id='ub_user' class='radius5' />
                        <label for='ub_pass'>Mdp : </label>
                        <input type='password' name='ub_pass' id='ub_pass' class='radius5' />
                        <input type='submit' value='' id='ub_submit' />
                    </p>
                </form>";
            $this->contenu['logged'] = false;
        }
    }

    /**
     * Methode qui permet d'afficher une vue demandée
     *
     * @param string $file fichier correspondant a la vue qu'on souhaite afficher
     * @return bool Retourne true si ca marche et false sinon.
     */
    function afficher_vue($file) {
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
                $this->affiche_erreur();

                return false;
            }
        }
    }

    function affiche_erreur($page) {
        $this->setUserBar();
        $contenu = $this->contenu;
        // gestion du probleme
        if (MODE == "dev") {
            $phrase = $this->error;
            require $page;
        } else {
            require $page;
        }
    }
    function set_error($txt){
        $this->error = $txt;
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
