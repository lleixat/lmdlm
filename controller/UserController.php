<?php

/**
 * Cette classe ne traitera que les trucs en rapport avec le USER
 * (login/inscription/delete etc..)
 *
 * @author rudak
 */
class UserController extends Controller {

    function login($params) {
        if (is_array($params) && isset($params['ub_user']) && isset($params['ub_pass']) && isset($params['ub_jeton'])) {

            if (isset($_SESSION['jeton']) && $_SESSION['jeton'] == $params['ub_jeton']) {

                require MODEL . DS . "Model.php";
                require MODEL . DS . "UserModel.php";
                $user = new UserModel();

                // on verifie dans la base via le UserModel qu'il y a une correspondance
                // si il y en a une l'id sera renvoyé, sinon => FALSE
                $id_user = $user->controle_identifiants($params['ub_user'], $params['ub_pass']);

                if ($id_user !== false) {
                    // correspondance confirmée, on peut logger le type
                    $_SESSION['login'] = true;
                    $_SESSION['id_user'] = $id_user;

                    // retour vers la page d'accueil suite au login
                    $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
                    $this->afficher_vue($file);
                } else {
                    // erreur de login
                    $this->error = $user->get_error();
                    $this->affiche_erreur();
                }
            } else {
                // error de jeton
                $this->error = "erreur de jeton";
                $this->affiche_erreur();
            }
        } else {
            // affichage page d'erreur perso
            echo "erreur arguments dans login()";
            var_dump($params);
        }
    }

    function deco() {
        session_destroy();

        header('Location:../accueil.html');
        exit;
        /*
        $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
        $this->afficher_vue($file);
         *
         */
    }

}

?>
