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

    /**
     *  affiche les resultats non validés
     */
    function resultatsMdlm() {
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $liste = $this->am->lister_resultats_a_valider();


        if ($liste !== false && count($liste) > 0) {
            $cadre = "<h3>Validation du resultat</h3>\n";
            foreach ($liste as $r) {

                if ($r->capture !== "") {
                    $dossier_img = "captures/" . date("Y", $r->heure);
                    $capture = $dossier_img . "/" . $r->capture;
                    $image = "<img src='{$capture}' alt='capture' class='capture' />";
                } else {
                    $image = "<p>*[probleme d'image..]*</p>";
                }

                $lien_non = "admin_refuserResultat/{$r->id_resultat}/administrer-resultat.html";
                $lien_oui = "admin_accepterResultat/{$r->id_resultat}/administrer-resultat.html";

                $date_mdlm = $this->formatteDate($r->heure);

                $phrase = "";
                $phrase .= "<p>{$date_mdlm} <b>{$r->user}</b> a recu le MDLM :</p>";
                $phrase .= "<div class='bigbig'>" . ucfirst($r->mot) . "</div>";

                $txt = str_replace($r->mot, "<span class='lmdlm'>{$r->mot}</span>", $r->phrase);

                $phrase .= "<p>Il a placé le mot dans la phrase suivante :</p>
                            <span class='phrase radius5'>" . ucfirst(nl2br($txt)) . "</span>";
                $phrase .= "<p>Voici sa capture d'écran :</p>";

                $phrase .= $image;

                $phrase .= "<p>Valider son MDLM ? 
                            <a href='{$lien_oui}' class='bouton radius5'>oui</a>
                            <a href='{$lien_non}' class='bouton radius5'>non</a></p>";

                $cadre .= "<div class='cadre_bleu radius10'>{$phrase}</div>\n";
            }
        } else {
            $phrase = "<h3>Validation du resultat</h3><p>Rien a valider, a demain.</p>";
            $cadre = "<div class='cadre_bleu radius10'>{$phrase}</div>\n";
        }


        $this->contenu['html'] = $cadre;
        $file = VUES . DS . $this->request->dossier . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function refuserResultat($id) {
        // si le mec n'est pas admin on l'envoi se faire foutre
        if (User::$rang < 5) {
            $this->error = "Tes admin depuis quand toi ?";
            $this->affiche_erreur();
        }

        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;

        $this->am->refuser_un_resultat($id);

        $contenu = "<h1>Administration</h1>";
        $contenu.= "<p>Vous avez refusé le resultat du gars, c'est la vie.</p>";

        $this->contenu['html'] = $contenu;

        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

    function accepterResultat($id) {
        // si le mec n'est pas admin on l'envoi se faire foutre
        if (User::$rang < 5) {
            $this->error = "Tes admin depuis quand toi ?";
            $this->affiche_erreur();
        }

        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;

        $this->am->accepter_un_resultat($id);

        $contenu = "<h1>Administration</h1>";
        $contenu.= "<p>Vous avez accepté le resultat du gars, quelle bonté.</p>";

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
        
        $model = "<p><span class='mot'>%s</span> <a href='%s'>%s</a> proposé par %s <span class='date'>%s</span>
            </p>";
        $html = "";
        
        foreach($liste as $mot){            
            if($mot->valide == 0){
                $image = "<img src='imgs/nonvalide.png' alt='img non valide' />";
                $lien = "admin_accepterMot/{$mot->id_mot}/administration-des-mots.html";
            } else {
                $image = "<img src='imgs/valide.png' alt='img valide' />";
                $lien = "admin_refuserMot/{$mot->id_mot}/administration-des-mots.html";
            }
            // /user_pageMembre/6/user_rudak.html
            $lien_user = "<a href='user_pageMembre/{$mot->id_user}/user_".$this->formatrewriting($mot->user).".html'>{$mot->user}</a>";
            $html .= sprintf($model,ucfirst($mot->mot),$lien,$image, $lien_user,$this->formatteDate($mot->date));
        }
        
        $this->contenu['liste'] = $html;
        
        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }
    
    function accepterMot($id){
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $this->am->accepter_un_Mot($id);
        
        $this->valideMots();
    }
    function refuserMot($id){
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;
        $this->am->refuser_un_Mot($id);
        
        $this->valideMots();
    }

}

?>
