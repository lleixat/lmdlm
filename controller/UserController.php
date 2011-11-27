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
                    // correspondance confirmée, on peut logger
                    $_SESSION['login'] = true;
                    $_SESSION['id_user'] = $id_user;



                    // retour vers la page precedente suite au login (ou a l'accueil par defaut)
                    //$redir = (isset($this->request->referer)) ? $this->request->referer : "../accueil.html";
                    //lastcrap_show/derniers-trucs.html
                    $redirUrl = "../news.html";
                    header('Location:' . $redirUrl);
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

                // on verifie les tentatives
                $resultats_valides = $user->compte_resultats_valides($id);
                $resultats_invalides = $user->compte_resultats_invalides($id);

                if ($resultats_valides > 0 || $resultats_invalides > 0) {
                    $nb_parties = $resultats_invalides + $resultats_valides;
                    $resultats  = "<table class='user_res'>\n<thead>\n";
                    $resultats .= "<th>Validés</th>\n";
                    $resultats .= "<th>Invalidés</th>\n";
                    $resultats .= "<th>Total</th>\n";
                    $resultats .= "</thead>\n</tbody>\n";
                    $resultats .= "<tr class='impair'><td>{$resultats_valides}</td>";
                    $resultats .= "<td>{$resultats_invalides}</td>";
                    $resultats .= "<td>{$nb_parties}</td></tr>";
                    $resultats .= "</tbody>\n</table>";
                } else {
                    $resultats = "<p>Aucune tentative pour l'instant.</p>";
                }

                // on prepare le html dynampique a envoyer a la page de membre
                $html = "";
                $html.= "<h2>{$infos->user}</h2>";
                $html.= "<div class='column1'>\n<ul>";
                $html.= "<li>Adresse e-mail : <a href='mailto:{$infos->mail}'>{$infos->mail}</a></li>";
                $html.= "<li>Date d'inscription  : <b>{$this->formatteDate($infos->inscription)}</b></li>";
                $html.= "<li>Dernière visite     : <b>{$this->formatteDate($infos->last)}</b></li>";
                $html.= "<li>Établissement       : <b>{$infos->type_etab}</b> de <b>{$infos->ville}</b></li>";
                $html.= "<li>Promotion           : <b>{$infos->promo}</b>  |  <b>{$infos->annee}/" . ($infos->annee + 1) . "</b></li>";
                $html.= "</ul>";
                $html .= "<p><a href='user_histo/{$id}/user_{$infos->user}.html'>Historique de ce joueur</a></p>";
                $html.= "</div>";
                $html.= "<div class='column2'>";
                $html .= "<h3>Résultats :</h3>";
                $html .= "<p>Les Mots de <b>{$infos->user}</b> :";
                $html .= $resultats . "</p>";
                $html.= "</div>";


                $this->contenu['user_infos_html'] = $html;

                $file = VUES . DS . $this->request->dossier . DS . "page-membre.html";
                $this->afficher_vue($file);
            } else {
                $this->error = "Aucun membre avec cette id ({$id})";
                $this->affiche_erreur(ERROR_SYS, $this->request->params);
                return false;
            }
        } else {
            $this->error = "Probleme avec le paramètre $id";
            $this->affiche_erreur(ERROR_SYS, $this->request->params);
            return false;
        }
    }

    /**
     * cette fonction va chercher la liste des membres via le usermodel et cree le html a mettre
     *  dans la page puis appelle la page
     */
    function listeMembres() {
        $um = new UserModel;
        $list_all = $um->liste_des_membres();
        $list_unv = $um->liste_des_membres(false);
        $id_unv = array();
        // on garde juste les id des mecs non validés pour comparer
        foreach ($list_unv as $membre_unv) {
            $id_unv[] = $membre_unv->user_id;
        }

        // modele ligne membre
        $mlm  = "<li><a href='user_pageMembre/%d/user_%s.html'>%s</a> inscrit depuis le %s ";
        $mlm .= "%s %s</li>\n";

        // contenu html
        $html = "<ul>\n";

        foreach ($list_all as $membre) {
            $image = (in_array($membre->id, $id_unv)) ? "<img src='imgs/pendule.png' alt='img' title='validation du compte' style='vertical-align: middle;' />" : "";
            $resultats_valides = $um->compte_resultats_valides($membre->id);
            $resultats_invalides = $um->compte_resultats_invalides($membre->id);
            if ($resultats_valides > 0 || $resultats_invalides > 0) {
                $nb_parties = $resultats_invalides + $resultats_valides;
                $resultats = "(" . $resultats_valides . "/" . $nb_parties . ")";
            } else {
                $resultats = "";
            }
            $urlUser = $this->formatrewriting($membre->user);
            $html .= sprintf($mlm, $membre->id, $urlUser, $membre->user, date('d/m/Y', $membre->inscription), $image, $resultats);
        }
        $html .= "</ul>\n";
        $this->contenu['liste_membre_html'] = $html;
        $file = VUES . DS . "user" . DS . "liste-membre.php";
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

                                        if ($fileController->upload_fichier($f, array("image/jpeg", "image/png"))) {
                                            // le fichier a été uploadé comme il faut
                                            // on peut lancer l'inscription dans la base
                                            // on recupere le nom de l'image qui a été créé
                                            $p['insc_image'] = $fileController->nouveau_nom;

                                            $userModel = new UserModel();
                                            $id = $userModel->enregistrer_new_user($p);

                                            if ($id !== false && $id > 0) {

                                                // on renseigne la table unvalidated_user
                                                $clef = substr(md5($id) . md5($p['insc_mail']), 0, 20) . md5("lemodlamort");
                                                $clef = sha1($clef);
                                                $userModel->ajoute_unvalidated_user($id, $clef);

                                                /*
                                                 * On ne logue pas le type des son inscription
                                                 $_SESSION['login'] = true;
                                                $_SESSION['id_user'] = $id;
                                                * 
                                                 */

                                                $lien_validation = "admin_validerMembre/$clef/validation-de-mon-compte.html";
                                                $fichier_mail = VUES . DS . 'mail' . DS . 'mail-validation.php';
                                                $contenu_mail = sprintf(file_get_contents($fichier_mail), filter_var($p['insc_user'], FILTER_SANITIZE_STRING), URL_BASE . $lien_validation);

                                                $message_txt = "Voilà le lien de validation de votre compte : " . $lien_validation;

                                                $this->envoyer_mail($contenu_mail, filter_var($p['insc_mail'], FILTER_SANITIZE_EMAIL), $message_txt);


                                                /*
                                                 * redirection vers une page qui lui dit de valider le mail avant 48heures
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

        // On met à jour le dernier passage de l'utilisateur
        $user= new UserModel();
        $user->maj_last_visite(User::$id);
        $user->maj_user_online(User::$id, false);

        session_destroy();

        header('Location:../accueil.html');
        exit;
    }

    function topScore() {
        $um = new UserModel;
        $liste = $um->liste_par_score();

        $html = "<ul>";
        $mdl_lienUser = "<a href='user_pageMembre/%d/user_%s.html'>%s</a>";
        $mdl_ligne = "<li>%s score : %d MDLM</li>";

        foreach ($liste as $user) {
            $score = ($user->score > 320) ? 320 : $user->score;
            $lien = sprintf($mdl_lienUser, $user->id, $this->formatrewriting($user->user), $user->user);
            $html.= sprintf($mdl_ligne, $lien, $user->score, $score);
        }
        $html .= "</ul>";
        $this->contenu['liste'] = $html;

        $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function envoyer_mail($message_html, $mail, $message_txt) {

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) { // On filtre les serveurs qui rencontrent des bogues.
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }

        $boundary = "-----=" . md5(rand());
        //==========
        //=====Définition du sujet.
        $sujet = "Bienvenue sur LMDLM";
        //=========
        //=====Création du header de l'e-mail.
        $header = "From: \"No Reply\"<postmaster@kadur-arnaud.fr>" . $passage_ligne;
        $header.= "Reply-to: \"No Reply\" <postmaster@kadur-arnaud.fr>" . $passage_ligne;
        $header.= "MIME-Version: 1.0" . $passage_ligne;
        $header.= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
        //==========
        //=====Création du message.
        $message = $passage_ligne . "--" . $boundary . $passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
        $message.= $passage_ligne . $message_txt . $passage_ligne;
        //==========
        $message.= $passage_ligne . "--" . $boundary . $passage_ligne;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
        $message.= $passage_ligne . $message_html . $passage_ligne;
        //==========
        $message.= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
        $message.= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
        //==========
        //=====Envoi de l'e-mail.
        mail($mail, $sujet, $message, $header);
    }

    function histo($id)
    {
        $id = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));

        if ($id > 0) {

            $user  = new UserModel();
            $histo = $user->histo_membre($id);


            if (count($histo)>0) {
            $html  = "<h2>Historique de <a href='user_pageMembre/{$histo[0]->id_user}/user_{$histo[0]->user}.html'>{$histo[0]->user}</a></h2>\n";
            $html .= "<p><u>Info:</u> rouge-> pas validé !</p>";
            $html .= "<div class='wrap_parent'>";
                $model .= "<h4><span class='clickme'>%s</span> - (%s)</h4>\n";
                $model .= "<div class='wrap'><p class='phrase' %s>%s</p>\n";
                $model .= "%s\n</div>";
                foreach ($histo as $entry) {
                    $name    = $entry->user;
                    $urlUser = $this->formatrewriting($entry->user);
                    $date    = date('d/m/y', $entry->heure);
                    $style   = ($entry->valide!=1) ? "style = 'color:Tomato;'" : "" ;
                    $phrase  = $entry->phrase;
                    $mot     = $entry->mot;

                    if ($entry->capture !== "") {
                        $dossier_img = "captures/" . date("Y", $entry->heure);
                        $capture     = $dossier_img . "/" . $entry->capture;
                        $image       = "<div class='capture'><img src='{$capture}' alt='capture'/></div>";
                    } else {
                        $image       = "<p class='embed_block'>Pas de capture...</p>";
                    }

                    $html .= sprintf($model, $mot, $date, $style, $phrase, $image);
                }                
            } else {
                $html  = "<h2>Historique ?</h2>\n";
                $html .= "<div>";
                $html .= "<p class='embed_block'>Pas d'historique pour ce joueur.</p>";


            }
                $html .= "</div>";
        }


        $this->contenu['histo'] = $html;

        $file = VUES . DS . $this->request->dossier . DS . "histo-resultats.html";
        $this->afficher_vue($file);

    }


}


#todo => faire systeme d'envoi du mail de confirmation du compte
#todo => ajouter table comptes confirmés ou pas et faire un truc pour que le mec valide son mail
?>
