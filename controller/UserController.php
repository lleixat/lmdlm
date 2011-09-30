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

                $user = new UserModel();

                // on verifie dans la base via le UserModel qu'il y a une correspondance
                // si il y en a une l'id sera renvoyé, sinon => FALSE
                $id_user = $user->controle_identifiants($params['ub_user'], $params['ub_pass']);

                if ($id_user !== false) {
                    // correspondance confirmée, on peut logger le type
                    $_SESSION['login'] = true;
                    $_SESSION['id_user'] = $id_user;

                    // retour vers la page d'accueil suite au login
                    header('Location:../accueil.html');
                    exit;
                } else {
                    // erreur de login
                    echo $this->request->set_request_type("error");
                    $this->error = $user->get_error();
                    $this->affiche_erreur(ERROR_SYS);
                }
            } else {
                // error de jeton
                $this->error = "erreur de jeton";
                $this->affiche_erreur(ERROR_SYS);
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
    }

}

?>
