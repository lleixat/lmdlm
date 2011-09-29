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

            $this->prp($params);
            require MODEL.DS."Model.php";
            require MODEL.DS."UserModel.php";
            $user = new UserModel();
            if($user->controle_identifiants($params['ub_user'], $params['ub_pass'])){
                echo "cool on peut logger";
            } else {
                // erreur de login
                echo $user->get_error();
            }
        } else {
            // affichage page d'erreur perso
            echo "erreur arguments dans login()";
            var_dump($params);
        }
    }

}

?>
