<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author rudak
 */
class AdminController extends Controller {

    private $am;
    private $um = false;

    /**
     *  affiche les resultats non validés
     */
    function resultatsMdlm() {
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $liste = $this->am->lister_resultats_a_valider();


        if ($liste !== false && count($liste) > 0) {
            $cadre = "<h3>Validation du résultat</h3>\n";
            foreach ($liste as $r) {

                if ($r->capture !== "") {
                    $dossier_img = "captures/" . date("Y", $r->heure);
                    $capture = $dossier_img . "/" . $r->capture;
                    $image = "<img src='{$capture}' alt='capture' class='capture' />";
                } else {
                    $image = "<p class='error'>*[ Problème d'image... ]*</p>";
                }

                $lien_non = "admin_refuserResultat/{$r->id_resultat}/administrer-resultat.html";
                $lien_oui = "admin_accepterResultat/{$r->id_resultat}/administrer-resultat.html";

                $date_mdlm = $this->formatteDate($r->heure);

                $phrase = "";
                $phrase .= "<p>{$date_mdlm} <b>{$r->user}</b> a reçu le mot :</p>";
                $phrase .= "<p class='bigbig'>" . ucfirst($r->mot) . "</p>";

                $txt = str_replace($r->mot, "<span class='lmdlm'>{$r->mot}</span>", $r->phrase);

                $phrase .= "<h4>Il a placé le mot dans la phrase suivante :</h4>
                            <p class='phrase'>" . ucfirst(nl2br($txt)) . "</p>";
                $phrase .= "<h4>Capture d'écran :</h4>";

                $phrase .= $image;

                $phrase .= "<p class='validation'>Valider son Mot ? 
                            <a href='{$lien_oui}'>oui</a> |
                            <a href='{$lien_non}'> nan !</a></p>";

                $cadre .= "<div>{$phrase}</div>\n";
            }
        } else {
            $phrase = "<h3>Validation du résultat</h3><p>Rien à valider, à demain.</p>";
            $cadre = "<div>{$phrase}</div>\n";
        }


        $this->contenu['html'] = $cadre;
        $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function refuserResultat($id) {
        // si le mec n'est pas admin on l'envoi se faire foutre
        if (User::$rang < 5) {
            $this->error = "T'es admin depuis quand toi ?";
            $this->affiche_erreur();
        }

        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;

        $this->am->refuser_un_resultat($id);

        $contenu = "<h2>Administration</h2>";
        $contenu.= "<p>Vous avez refusé le resultat du gars, c'est la vie.</p>";

        $this->contenu['html'] = $contenu;

        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function accepterResultat($id) {
        // si le mec n'est pas admin on l'envoi se faire foutre
        if (User::$rang < 5) {
            $this->error = "T'es admin depuis quand toi ?";
            $this->affiche_erreur();
        }

        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;

        $this->am->accepter_un_resultat($id);

        $contenu = "<h2>Administration</h2>";
        $contenu.= "<p>Vous avez accepté le résultat du gars, quelle bonté.</p>";

        $this->contenu['html'] = $contenu;

        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function accepter_mot($id) {
        
    }

    function refuser_mot($id) {
        
    }

    function valideMots() {
        require MODEL . DS . 'MotModel.php';
        $this->mm = new MotModel;
        $liste = $this->mm->liste_mot_et_posteur();

        $model = "<li><b>%s</b> <a href='%s'>%s</a> proposé par %s %s</li>";
        $html = "";

        foreach ($liste as $mot) {
            if ($mot->valide == 0) {
                $image = "<img src='imgs/nonvalide.png' alt='img non valide' />";
                $lien = "admin_accepterMot/{$mot->id_mot}/administration-des-mots.html";
            } else {
                $image = "<img src='imgs/valide.png' alt='img valide' />";
                $lien = "admin_refuserMot/{$mot->id_mot}/administration-des-mots.html";
            }
            // /user_pageMembre/6/user_rudak.html
            $lien_user = "<a href='user_pageMembre/{$mot->id_user}/user_" . $this->formatrewriting($mot->user) . ".html'>{$mot->user}</a>";
            $html .= sprintf($model, ucfirst($mot->mot), $lien, $image, $lien_user, $this->formatteDate($mot->date));
        }

        $this->contenu['liste'] = $html;

        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function accepterMot($id) {
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $this->am->accepter_un_Mot($id);

        $this->valideMots();
    }

    function refuserMot($id) {
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $this->am->refuser_un_Mot($id);

        $this->valideMots();
    }

    // ------------------------

    function gererMembres() {
        $this->um = ($this->um == false) ? new UserModel() : $this->um;
        $liste = $this->um->liste_membres();

        $lien_bannir = "<a href='admin_banMembre/%d/bannir-membre.html' title='bannir ce membre'><img src='imgs/trash.gif' alt='poubelle' /></a>";
        $lien_membre = "<a href='admin_addMembre/%d/ajouter-membre.html' title='ajouter un membre'><img src='imgs/user.png' alt='ajout' /></a>";
        $lien_admin = "<a href='admin_addAdmin/%d/ajouter-admin.html' title='ajouter un admin'><img src='imgs/admin.png' alt='ajout' /></a>";

        $t = "<tr class='%s'>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
             </tr>\n";

        $html =  "<table>
                    <thead>
                        <th>Pseudo</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </thead>
                    <tbody>\n";

        $html_liens = "";
        $niveau = array('banni', 'en attente', 'membre', 'modérateur', 'admin', 'admin');
        $ligne = 0;
        foreach ($liste as $membre) {
            // classe alternée de la ligne
            $classe = (++$ligne % 2 == 0) ? "pair" : "impair";

            // le lien a afficher pour la gestion du membre
            $id = $membre->id;
            $html_liens = "";
            switch ($membre->rang) {
                case 0:
                    $html_liens.= sprintf($lien_membre, $id);
                    $html_liens.= sprintf($lien_admin, $id);
                    break;
                case 1:
                    $html_liens.= sprintf($lien_bannir, $id);
                    $html_liens.= sprintf($lien_membre, $id);
                    $html_liens.= sprintf($lien_admin, $id);
                    break;
                case 2:
                    $html_liens.= sprintf($lien_bannir, $id);
                    $html_liens.= sprintf($lien_admin, $id);
                    break;
                case 5:
                    $html_liens.= sprintf($lien_bannir, $id);
                    $html_liens.= sprintf($lien_membre, $id);
                    break;
            }
            // on ne peut pas s'auto administrer
            if ($id == User::$id)
                $html_liens = '';
            $html .= sprintf($t, $classe, $membre->user, $niveau[$membre->rang], $html_liens);
        }
        $html .= "</tbody>\n</table>\n";

        // on reserve le privilège a l'admin
        if (User::$rang > 2)
            $this->contenu['html'] = $html;
        else
            $this->contenu['html'] = "<p>T'es pas admin blaireau...</p>";


        $file = VUES . DS . 'admin' . DS . 'administration-membres.php';
        $this->afficher_vue($file);
    }

    function banMembre($id) {
        $this->um = ($this->um == false) ? new UserModel() : $this->um;
        // on controle si le gars est admin
        if (User::$rang > 2) {
            $this->um->banMembre($id);
        }
        $this->gererMembres();
    }

    function addMembre($id) {
        $this->um = ($this->um == false) ? new UserModel() : $this->um;
        // on controle si le gars est admin
        if (User::$rang > 2) {
            $this->um->addMembre($id);
        }
        $this->gererMembres();
    }

    function addAdmin($id) {
        $this->um = ($this->um == false) ? new UserModel() : $this->um;
        // on controle si le gars est admin
        if (User::$rang > 2) {
            $this->um->addAdmin($id);
        }
        $this->gererMembres();
    }

    function validerMembre($hash) {
        $this->um = ($this->um == false) ? new UserModel() : $this->um;
        $this->um->validerMembre($hash);

        $file = VUES . DS.'static' . DS . 'juste-valide.php';
        $this->afficher_vue($file);
    }

}

?>
