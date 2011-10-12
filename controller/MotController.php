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

        $this->contenu['html_prop_mot'] = ($this->mm->ajouter_mot($mot) == 1)?"<p>Mot '<b>{$mot}</b>' envoyé ! </p>":"<p>Ca a foiré chef ! Votre mot n'a pas été envoyé! <br />Il est surement déja dans la base... <br /><b>Vérifie !</b></p>";
        $this->mots_proposes_du_gars();
        $this->liste_tous_les_mots();

        $file = VUES . DS . "mot" . DS . "proposer-mot.html";
        $this->afficher_vue($file);
    }

    /**
     *  recupere le contenu (la liste de mots déja envoyée)
     *  et envoie la page de proposition de mot
     *  (une page statique avec du contenu non statique)
     */
    function afficher() {
        $this->mots_proposes_du_gars();
        $this->liste_tous_les_mots();

        if (User::$id !== null) {
            $pm_jeton = md5(CLE_SHA_PERSO . time() . rand(0, 15));
            $_SESSION['jeton_prop_mot'] = $pm_jeton;

            $html = "<form action='mot_proposer/proposer-mot.html' enctype='multipart/form-data' method='post' id='pm_form'>
                        <p>
                            <input type='hidden' name='pm_jeton' value='{$pm_jeton}' />
                            <label for='pm_mot'>Quel mot souhaitez vous proposer ?</label><br />
                            <input type='text' name='pm_mot' id='pm_mot' /><br />
                            <input type='submit' value='Proposer !' />
                        </p>
                    </form>";
        } else {
            $html = "<p>Vous devez etre inscrit pour proposer un mot</p>";
        }

        $this->contenu['html_prop_mot'] = $html;

        $file = VUES . DS . "mot" . DS . "proposer-mot.html";
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
            $titre = (User::$id !== null) ? "Vous avez proposé" : "Les derniers mots proposés";
            $html = "<div class='cadre_bleu radius10'>\n<h2>{$titre}</h2>\n";
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

    function liste_tous_les_mots() {
        
        // on ne cree l'objet que si il n'existe pas
        if (!is_object($this->mm)) {
            require MODEL . DS . 'MotModel.php';
            $this->mm = new MotModel;
        }
        $liste = $this->mm->liste_mots(false,false,true);

        if (count($liste) > 0) {
            
            $html = "<div class='cadre_bleu radius10'>\n<h2>Tous les mots disponibles</h2>\n";
            $mdl_ligne_mot = "<p><span class='mot'>%s</span> 
                                <img src='%s' alt='validation' /> proposé %s </p>\n";
            foreach ($liste as $mot) {
                $date = $this->formatteDate($mot->date);
                $image = ($mot->valide == 1) ? "imgs/valide.png" : "imgs/nonvalide.png";
                $html.= sprintf($mdl_ligne_mot, $mot->mot, $image, $date);
            }
            $this->contenu['liste_tous_mots'] = $html . "</div>";
        } else {
            $this->contenu['liste_tous_mots'] = "
                <div class='cadre_bleu'>
                    <h2>Y a pas de mots la dedans...</h2>
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

        $phrase = "";

        if ($objmot->id_resultat == 0) {
            $lien_resultat = "<p>
                <a href='mot_reussite/signaler-ma-reussite.html' 
                            class='bouton radius5'>J'ai réussi !</a></p>";
            $phrase .= "<p>Voila ton mot d'aujourd'hui : <div class='bigbig'>".ucfirst($objmot->mot)."</div> bonne chance !</p>" . $lien_resultat;
        } else {
            $lien_resultat = "";

            $etat_de_validation = $this->mm->ce_resultat_est_il_valide($objmot->id_resultat);

            // on va chercher l'image qui correspond au statut du resultat
            switch ($etat_de_validation) {
                case "0": // en attente de validation 
                    $image = "<img src='imgs/pendule.png' alt='img statut' />";
                    $phrase .= "<p>{$image} Ajourd'hui ton mot était '<b>{$objmot->mot}</b>',<br /> tu dois attendre la validation...</b>'</p>" . $lien_resultat;
                    break;
                case "1": // validé
                    $image = "<img src='imgs/valide.png' alt='img statut' />";
                    $phrase .= "<p>{$image} Ta tentative à été validée pour le mot <b>{$objmot->mot}</b> !</p>" . $lien_resultat;
                    break;
                case "9": // refusé par un enculé^^
                    $image = "<img src='imgs/nonvalide.png' alt='img statut' />";
                    $phrase .= "<p>{$image} Tentative pour le mot '<b>{$objmot->mot}</b>' refusée, tu feras mieux demain...</p>" . $lien_resultat;
                    break;
                default :
                    $image = "";
                    break;
            }
        }


        $this->contenu['phrase'] = $phrase;
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
            $mdl = "<p>%s LMDLM était : <b>%s</b> %s</p>";
            foreach ($liste as $motjour) {
                
                $id_resultat  = $motjour->id_resultat;
                if($id_resultat > 0){
                $valide = $this->mm->ce_resultat_est_il_valide($id_resultat);

                switch($valide){
                    case "0":
                        $img = "<img src='imgs/pendule.png' alt='statut' title='Tentative en attente de validation' />";
                        break;
                    case "1":
                        $img = "<img src='imgs/valide.png' alt='statut' title='Tentative validée' />";
                        break;
                    case "9":
                        $img = "<img src='imgs/nonvalide.png' alt='statut' title='Tentative refusée' />";
                        break;
                }
                } else {
                     $img = "<img src='imgs/excla.png' alt='statut' title='Tentative non réussie dans les temps' />";
                }
                
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

                $phrase = "<p>Aujourd'hui " . User::$user . ", tu devais réussir a placer le mot :</p>";
                $phrase.= "<div class='bigbig'>" . ucfirst($infos->mot) . "</div>";
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
                $capture = $fc->nouveau_nom;

                // on déplace la capture dans un dossier plus approprié 
                // on le cree si il n'existe pas
                $dossier = WEB . DS . "captures" . DS . date("Y", time());
                if (!file_exists($dossier) || !is_dir($dossier)) {
                    // il n'existe pas , on le crée
                    if (!mkdir($dossier, 0777)) {
                        $this->error = "Le fichier ne peut pas etre créé donc on ne peut pas continuer";
                        $this->affiche_erreur();
                    }
                }
                // on compresse la grande vers le bon dossier et une taille plus correcte
                if (!$fc->compresse_image(UPLOADS . DS . $capture, 600, $dossier . DS, 80)) {
                    $this->error = $fc->error;
                    $this->affiche_erreur();
                } else {
                    // on vire la grande
                    unlink(UPLOADS . DS . $capture);
                }






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
    }
}

?>
