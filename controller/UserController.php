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
    
    /**
     * cette fonction va chercher la liste des membres via le usermodel et cree le html a mettre
     *  dans la page puis appelle la page
     */
    function listeMembres(){
        $um = new UserModel;
        $list_all = $um->liste_des_membres();
        $list_unv = $um->liste_des_membres(false);
        $id_unv = array();
        // on garde juste les id des mecs non validés pour comparer
        foreach($list_unv as $membre_unv){
            $id_unv[] = $membre_unv->user_id;
        }
        
        // modele ligne membre
        $mlm = "<p><a href='user_pageMembre/%d/user_%s.html' class='lien_membre'>%s</a> inscrit le ";
        $mlm.= "<span class='date_insc'>%s</span> ";
        $mlm.= "<img src='%s' alt='validation du compte' style='vertical-align: middle;' /></p>\n";
        
        // contenu html
        $html = "";
        
        foreach($list_all as $membre){
            $image = (in_array($membre->id, $id_unv))?"imgs/nonvalide.png":"imgs/valide.png";
            $urlUser = $this->formatrewriting($membre->user);
            $html .= sprintf($mlm,$membre->id,$urlUser,$membre->user,date('d/m/Y',$membre->inscription),$image);
        }
        $this->contenu['liste_membre_html'] = $html;
        $file = VUES.DS."user".DS."liste-membre.php";
        $this->afficher_vue($file);
    }

    function inscription($p, $file) {

        if (strlen($p['insc_user']) >= 3 && strlen($p['insc_user']) <= 40) {
            if (strlen($p['insc_pass']) >= 6 && strlen($p['insc_pass']) <= 17) {
                if ($p['insc_pass'] == $p['insc_pass2']) {
                    if (filter_var($p['insc_mail'], FILTER_VALIDATE_EMAIL)) {
                        if ($p['insc_type_etab'] > 0) {
                            if (strlen($p['insc_ville_etab']) > 0) {
                                if (strlen($p['insc_promo_etab']) > 0) {
                                    if (empty($p['iQapTcha']) && isset($_SESSION['iQaptcha']) && $_SESSION['iQaptcha']) {

                                        // les infos ont l'air bonnes
                                        // on upload le fichier image et si ca se passe
                                        // bien on rentre tout dans la base

                                        $f = $file['insc_avatar'];
                                        require CONTROLLER . DS . 'FileController.php';
                                        $fileController = new FileController();

                                        if ($fileController->upload_fichier($f, array("image/jpeg"))) {
                                            // le fichier a été uploadé comme il faut
                                            // on peut lancer l'inscription dans la base
                                            // on recupere le nom de l'image qui a été créé
                                            $p['insc_image'] = $fileController->nouveau_nom;

                                            $userModel = new UserModel();
                                            $id = $userModel->enregistrer_new_user($p);

                                            if ($id !== false && $id > 0) {
                                                
                                                // on renseigne la table unvalidated_user
                                                $clef = md5($id).md5($p['insc_mail']).md5("lemodlamort");
                                                $clef = sha1($clef);
                                                $userModel->ajoute_unvalidated_user($id,$clef);

                                                $_SESSION['login'] = true;
                                                $_SESSION['id_user'] = $id;


                                                /* redirection a revoir plus tard
                                                 * vers une page qui lui dit de valider le mail avant 48heures
                                                 */

                                                header('Location:../user_juste-inscrit.html');
                                                exit;
                                            }
                                        } else {
                                            $this->error = "Echec du déplacement du fichier tmp.";
                                            $this->affiche_erreur(ERROR_SYS);
                                        }
                                    } else {
                                        // probleme de captcha
                                        $this->error = "Erreur de captcha.";
                                        $this->affiche_erreur(ERROR_SYS);
                                    }
                                } else {
                                    // mauvaise promo
                                    $this->error = "Promotion incorrecte.";
                                    $this->affiche_erreur(ERROR_SYS);
                                }
                            } else {
                                // mauvaise ville
                                $this->error = "Ville incorrecte.";
                                $this->affiche_erreur(ERROR_SYS);
                            }
                        } else {
                            // mauvais type d'etablissement
                            $this->error = "Type d'établissement incorrect.";
                            $this->affiche_erreur(ERROR_SYS);
                        }
                    } else {
                        // mail incorrect
                        $this->error = "Mail incorrect.";
                        $this->affiche_erreur(ERROR_SYS);
                    }
                } else {
                    // erreur simmilarité de la confirmation du mdp
                    $this->error = "Confirmation du mot de passe incorrecte.";
                    $this->affiche_erreur(ERROR_SYS);
                }
            } else {
                // erreur taille pass
                $this->error = "Taille du mot de passe incorrecte.";
                $this->affiche_erreur(ERROR_SYS);
            }
        } else {
            // erreur taille pseudo
            $this->error = "Taille du pseudo incorrecte.";
            $this->affiche_erreur(ERROR_SYS);
        }
    }

    function deco() {
        session_destroy();

        header('Location:../accueil.html');
        exit;
    }

}

#todo => faire systeme d'envoi du mail de confirmation du compte
#todo => ajouter table comptes confirmés ou pas et faire un truc pour que le mec valide son mail
?>