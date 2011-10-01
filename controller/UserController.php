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


    /**
     *
     * @param int $id l'id du membre a afficher
     * @return html le html de la page membre
     */
    function pageMembre($id) {
        // on s'écurise l'id vu qu'il vient de l'extérieur
        $id = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));
        if ($id > 0) {

            // on fait une liaison avec le model
            $user = new UserModel();
            $infos = $user->get_userInfos($id);

            if ($infos !== false && is_object($infos)) {

                // $this->prp($infos);
                // on prepare le html dynampique a envoyer a la page de membre
                $html = "";
                $html.= "<h1>{$infos->user}</h1>";
                $html.= "<p>Adresse e-mail : {$infos->mail}</p>";
                $html.= "<p>Date d'inscription  : {$this->formatteDate($infos->inscription)}</p>";
                $html.= "<p>Derniere visite     : {$this->formatteDate($infos->last)}</p>";
                $html.= "<p>Etablissement       : {$infos->type_etab} de {$infos->ville}</p>";
                $html.= "<p>Promotion           : {$infos->promo}  |  {$infos->annee}/" . ($infos->annee + 1) . "</p>";


                $this->contenu['user_infos_html'] = $html;

                $file = VUES . DS . $this->request->dossier . DS . "page-membre.html";
                $this->afficher_vue($file);
            } else {
            $this->error = "Aucun membre avec cette id ({$id})";
            $this->affiche_erreur(ERROR_SYS, $this->request->params);
            return false;
            }
        } else {
            $this->error = "Probleme avec le parametre $id";
            $this->affiche_erreur(ERROR_SYS, $this->request->params);
            return false;
        }
    }


    function inscription(){
        $this->error = "ici il faut recupérér les infos, les filter et si tout est bon, instancier le model userModel, faire une methode qui va envoyer les infos dans la base et rediriger vers la page request->page";
        $this->affiche_erreur(ERROR_SYS,$this->request);
    }

    function deco() {
        session_destroy();

        header('Location:../accueil.html');
        exit;
    }

}

?>
