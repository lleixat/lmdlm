<?php

class MotController extends Controller {

    private $mm;

    /**
     *  enregistre un mot et affiche la liste de mots que le gars a déja proposé
     * @param string $p le mot proposé
     */
    function proposer($p) {

        $jeton = $p['pm_jeton'];
        $mot = filter_var($p['pm_mot'], FILTER_SANITIZE_STRING);

        require MODEL . DS . 'MotModel.php';
        $this->mm = new MotModel;

        $this->mm->ajouter_mot($mot);
        $this->mots_proposes_du_gars();

        $file = VUES . DS . "static" . DS . "proposer-mot.html";
        $this->afficher_vue($file);
    }

    /**
     *  recupere le contenu (la liste de mots déja envoyée)
     *  et envoie la page de proposition de mot
     *  (une page statique avec du contenu non statique)
     */
    function afficher() {
        $this->mots_proposes_du_gars();
        $file = VUES . DS . "static" . DS . "proposer-mot.html";
        $this->afficher_vue($file);
    }

    /*
     * renvoie la liste des mots que le mec a deja proposé
     */

    function mots_proposes_du_gars() {
        // on ne cree l'objet que si il n'existe pas
        if (!is_object($this->mm)) {
            require MODEL . DS . 'MotModel.php';
            $this->mm = new MotModel;
        }
        $liste = $this->mm->liste_mots(User::$id, 25);

        if (count($liste) > 0) {
            $html = "<div class='cadre_bleu radius10'>\n<h2>Vous avez proposé</h2>\n";
            $mdl_ligne_mot = "<p><span class='mot'>%s</span> 
                                <img src='%s' alt='validation' /> proposé %s </p>\n";
            foreach ($liste as $mot) {
                $date = $this->formatteDate($mot->date);
                $image = ($mot->valide == 1) ? "imgs/valide.png" : "imgs/nonvalide.png";
                $html.= sprintf($mdl_ligne_mot, $mot->mot, $image, $date);
            }
            $this->contenu['liste_mots_user'] = $html . "</div>";
        } else {
            $this->contenu['liste_mots_user'] = "<div class='cadre_bleu'>
                <h2>Vous n'avez proposé aucuns mots</h2>
            </div>";
        }
    }

    /**
     *  assigne un mot au gars pour la journée
     */
    function obtenir() {
        require MODEL . DS . 'MotModel.php';
        $this->mm = new MotModel;

        $objmot = $this->mm->assigne_mot();

         if ($objmot->id_resultat == 0) {
            $lien_resultat = "<p>
                <a href='mot_reussite/signaler-ma-reussite.html' 
                            class='bouton radius5'>J'ai réussi !</a></p>";
            $image ="";
        } else {
            $lien_resultat = "";
            
            $etat_de_validation = $this->mm->ce_resultat_est_il_valide($objmot->id_resultat);
            switch ($etat_de_validation) {
                case "0":
                    // en attente de validation 
                    $image = "<img src='imgs/pendule.png' alt='img statut' />";
                    break;
                case "1":
                    $image = "<img src='imgs/valide.png' alt='img statut' />";
                    break;
                case "9":
                    $image = "<img src='imgs/nonvalide.png' alt='img statut' />";
                    break;
                default :
                    $image = "";
                    break;
            }
        }




        $mot_today = "";
        $mot_today.= "<p>Aujourd'hui, jour {$objmot->jour} de l'an {$objmot->annee}, ";
        $mot_today.= "votre mot est : <b>{$objmot->mot}</b>.{$image}</p>";
        $mot_today.= $lien_resultat;

        $this->contenu['mot_today'] = $mot_today;
        $this->contenu['histo'] = $this->preparer_historique_mots_perso();

        $file = VUES . DS . "mot" . DS . "le-mot-du-jour.html";
        $this->afficher_vue($file);
    }

    /**
     * Les mots que le mec a deja eu avant aujourd'hui
     */
    function preparer_historique_mots_perso() {
        $liste = $this->mm->historique_mots_perso();

        if (count($liste) > 0) {
            $html = "";
            $mdl = "<p>%s LMDLM était : <b>%s</b>
                    <img src='imgs/%s' alt='statut resultat' /></p>";
            foreach ($liste as $motjour) {
                $img = ($motjour->id_resultat == 0) ? "nonvalide.png" : "valide.png";
                $date = ucfirst($this->formatteDate($motjour->heure));
                $html.= sprintf($mdl, $date, $motjour->mot, $img);
            }
        } else {
            $html = "<p>Pas encore d'historique...</p>";
        }
        return $html;
    }

    function reussite() {
        require MODEL . DS . 'MotModel.php';
        $this->mm = new MotModel;
        $infos = $this->mm->renvoie_infos_mot_du_jour();
       
        
        if (is_object($infos)) {

            if ($infos->id_resultat == 0) {

                $phrase = "<p>Aujourd'hui ".User::$user.", tu devais réussir a placer le mot :</p>";
                $phrase.= "<div class='bigbig'>".ucfirst($infos->mot)."</div>";
                $phrase.= "<p>Dans quelle phrase l'avez vous placé ?</p>";
                $form = "<form action='mot_signalerReussite/validation-du-mot.html' 
                          enctype='multipart/form-data' id='vm_form' method='post'>
                        <p>
                            <input type='hidden' name='hash' value='{$infos->hash}' />
                            <textarea name='vm_phrase' id='vm_phrase' cols='30' rows='10' class='radius10'></textarea>
                        </p>\n
                        <p>
                            <label for='vm_capture'>capture d'ecran</label><br />
                            <input type='file' name='vm_capture' id='vm_capture' /><br />
    
                            <input type='submit' value='ENVOYER' />\n
                        </p>\n
                    </form>\n";
            } else {
                $phrase = "<p>Tout est déja signalé ;)</p>";
                $form = "";
            }
        } else {
            $phrase = "<p>Il y a un probleme avec votre mot du jour...</p>";
            $form = "";
        }

        $this->contenu['phrase'] = $phrase;
        $this->contenu['form'] = $form;

        $file = VUES . DS . "mot" . DS . "signaler-ma-reussite.php";
        $this->afficher_vue($file);
    }

    function signalerReussite($p, $f) {
        /**
         * recupere les infos pouvant démontrer que le mec a réussi ou pas
         * avant la validation par les admin
         */
        if (isset($f['vm_capture']) && $f['vm_capture']['error'] == 0) {
            $f = $f['vm_capture'];
            require CONTROLLER . DS . 'FileController.php';
            $fc = new FileController;

            $upload = $fc->upload_fichier($f, array("image/jpeg", "image/png"));
            if ($upload) {
                // l'upload a bien été fait
                // prévoir la compression et le déplacement vers un autre dossier plus approprié
                $capture = $fc->nouveau_nom;
                $phrase = filter_var($p['vm_phrase'], FILTER_SANITIZE_STRING);
                $hash = $p['hash'];

                require MODEL . DS . 'MotModel.php';
                $this->mm = new MotModel;

                /*
                 *  on enregistre la phrase et la capture dans la base                
                 *  ca doit retourner l'id de resultat.
                 *  on le prend et on le place dans le mot_du_jour pour faire le lien
                 *  entre le mot a trouver, et le resultat fourni par le type
                 */
                $id_resultat = $this->mm->enregistrer_resultat_du_gars($phrase, $capture);

                if ($id_resultat > 0) {
                    // on met le mot du jour en attente de validation
                    if ($this->mm->maj_mdj_attente_validation($id_resultat, $hash)) {
                        // impecable

                        header('Location:../mot_resultat-en-attente.html');
                    } else {
                        // erreur de mise a jour du 'mot_du_jour' du gars
                        $this->error = "Echec de mise a jour du statut du mot de la mort.";
                        $this->affiche_erreur();
                    }
                } else {
                    // probleme interne d'enregistrement du resultat
                    $this->error = "Probleme lors de l'enregistrement du resultat.($id_resultat)";
                    $this->affiche_erreur();
                }
            } else {
                // upload foiré
                $this->error = $fc->error;
                $this->affiche_erreur();
            }
        } else {
            $this->error = "Vous avez oublié la capture d'ecran !";
            $this->affiche_erreur();
        }

        //$this->affiche_erreur(ERROR_SYS,$this->request->params);
    }

}

?>
