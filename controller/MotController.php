<?php

class MotController extends Controller {

    /**
     *  enregistre un mot et affiche la liste de mots que le gars a déja proposé
     * @param string $p le mot proposé
     */
    function proposer($p) {

        $jeton = $p['pm_jeton'];
        $mot = filter_var($p['pm_mot'], FILTER_SANITIZE_STRING);

        require MODEL . DS . 'MotModel.php';
        $mm = new MotModel;
        $mm->ajouter_mot($mot);
        $liste = $mm->liste_mots(User::$id);
        
        if (count($liste) > 0) {
            $html = "<div class='cadre_bleu radius10'><h2>Vous avez proposé</h2>";
            $mdl_ligne_mot = "<p><span class='mot'>%s</span> <img src='%s' alt='validation' /> proposé %s </p>\n";
            foreach ($liste as $mot) {
                $date = $this->formatteDate($mot->date);
                $image = ($mot->valide == 0) ? "imgs/valide.png" : "imgs/nonvalide.png";
                $html.= sprintf($mdl_ligne_mot, $mot->mot, $image, $date);
            }
            $this->contenu['liste_mots_user'] = $html . "</div>";
        } else {
            $this->contenu['liste_mots_user'] = "<div class='cadre_bleu'>
                <h2>Vous n'avez proposé aucuns mots</h2>
            </div>";
        }

        $file = VUES . DS . "static" . DS . "proposer-mot.html";
        $this->afficher_vue($file);
    }

    /**
     *  cree le contenu (la liste de mots déja envoyée)
     *  et envoie la page de proposition de mot
     */    
    function afficher() {
        require MODEL . DS . 'MotModel.php';
        $mm = new MotModel;
        $liste = $mm->liste_mots(User::$id,25);
        if (count($liste) > 0) {
            $html = "<div class='cadre_bleu radius10'><h2>Vous avez proposé</h2>";
            $mdl_ligne_mot = "<p><span class='mot'>%s</span> <img src='%s' alt='validation' /> proposé %s </p>\n";
            foreach ($liste as $mot) {
                $date = $this->formatteDate($mot->date);
                $image = ($mot->valide == 0) ? "imgs/valide.png" : "imgs/nonvalide.png";
                $html.= sprintf($mdl_ligne_mot, $mot->mot, $image, $date);
            }
            $this->contenu['liste_mots_user'] = $html . "</div>";
        } else {
            $this->contenu['liste_mots_user'] = "<div class='cadre_bleu'>
                <h2>Vous n'avez proposé aucuns mots</h2>
            </div>";
        }

        $file = VUES . DS . "static" . DS . "proposer-mot.html";
        $this->afficher_vue($file);
    }

    /**
     *  assigne un mot au gars pour la journée
     */
    function obtenir(){
        require MODEL . DS . 'MotModel.php';
        $mm = new MotModel;

        $objmot = $mm->assigne_mot();
  
        //$this->prp($objmot);
                
        $mot_today = "";
        $mot_today.= "<p>Aujourd'hui, jour {$objmot->jour} de l'an {$objmot->annee}, 
                    votre mot est : <b>{$objmot->mot}</b>.</p>";
        
        $this->contenu['mot_today'] = $mot_today;
        
        $file = VUES . DS . "static" . DS . "le-mot-du-jour.html";
        $this->afficher_vue($file);
    }
}

?>
