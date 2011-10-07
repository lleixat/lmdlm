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
        //$this->contenu['liste'] = $this->am->lister_resultats_a_valider();

        if ($liste !== false && count($liste) > 0) {
            $cadre = "<h3>Validation du resultat</h3>\n";
            foreach ($liste as $r) {
                $phrase = "";
                $lien_non = "admin_refuserResultat/{$r->id_resultat}/administrer-resultat.html";
                $lien_oui = "admin_accepterResultat/{$r->id_resultat}/administrer-resultat.html";
                $date_mdlm = $this->formatteDate($r->heure);
                $phrase .= "<p>{$date_mdlm} <b>{$r->user}</b> a recu le MDLM :</p>";
                $phrase .= "<div class='bigbig'>".ucfirst($r->mot)."</div>";
                
                $txt = str_replace($r->mot, "<span class='lmdlm'>{$r->mot}</span>", $r->phrase);
                
                $phrase .= "<p>Il a placé le mot dans la phrase suivante :</p>
                            <span class='phrase radius5'>".ucfirst(nl2br($txt))."</span>";
                $phrase .= "<p>Voici sa capture d'écran :</p>";
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
        require MODEL . DS . 'AdminModel.php';
        $this->am = new AdminModel;

        $this->am->accepter_un_resultat($id);

        $contenu = "<h1>Administration</h1>";
        $contenu.= "<p>Vous avez accepté le resultat du gars, quelle bonté.</p>";

        $this->contenu['html'] = $contenu;

        $file = VUES . DS . "admin" . DS . $this->request->vue;
        $this->afficher_vue($file);
    }

}

?>
