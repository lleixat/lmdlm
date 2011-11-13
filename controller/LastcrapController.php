<?php

/**
 * 
 */


class LastcrapController extends Controller
{

    function show()
    {
        $this->dmInscrits(User::$id);
        $this->dmValides(User::$id);
        $file = VUES . DS . "user" . DS . "derniers-trucs.html";
        $this->afficher_vue($file);

    }

    function dmInscrits($cUser=null)
    {
        if (!is_object($this->lcm)) {
            require MODEL . DS . 'LastcrapModel.php';
            $this->lcm = new LastCrap;

        }
        $list =  $this->lcm->dernier_membres_inscrits($cUser, $row=5);
/*       // debug*/
        //echo "<pre style='color:#000'>";
            //print_r($list);
        //echo "</pre>";
        /*//end debug*/
        if (count($list)>0) {
            $html    = "<ul>";
            $model  .= "<li><a href='user_pageMembre/%d/user_%s.html'>%s</a> [ %s ]</li>";
            foreach ($list as $user) {
                $id      = $user->id;
                $name    = $user->user;
                $urlUser = $this->formatrewriting($user->user);
                $insc    = date('d/m/y', $user->first);

                $html .= sprintf($model, $id, $urlUser, $name,  $insc);
            }
            $html .= "</ul>\n";
        } else {
            $html .= "<p style='color:Tomato;'>Aucun membre ne s'est inscrit depuis votre dernière connexion.</p>";
        }
        $this->contenu['dmInsc'] = $html;
    }


    function dmValides($cUser=null)
    {
        /**
         * Renvoie la liste des derniers mots validés depuis
         * la dernière connexion de l'utilisateur
         *
         * @param 
         * @return array
         */

        if (!is_object($this->lcm)) {
            require MODEL . DS . 'LastcrapModel.php';
            $this->lcm = new LastCrap;
        }

        $list =  $this->lcm->dernier_mots_valides($cUser, $row=10);
       //// debug
        //echo "<pre style='color:#000'>";
            //print_r($list);
        //echo "</pre>";
        ////end debug

        if (count($list)>0) {
            $html   = "<ul>";
            $model .= "<li><b>%s</b> [ %s ]";
            
            foreach ($list as $lm) {
                $mot   = $lm->mot;
                $date  = date('d/m/y', $lm->date);

                $html .= sprintf($model, $mot, $date, $prop);
            }
            $html .= "</ul>\n";
        } else {
            $html .= "<p style='color:Tomato;'>Aucun mot n'a été validé depuis votre dernière connexion.</p>";
        }
        $this->contenu['dmVal'] = $html;
    }



}

?>
