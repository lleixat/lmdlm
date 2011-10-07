<?php

class MotModel extends Model {

    function ajouter_mot($mot) {
        $sql = "INSERT INTO mots VALUES (?,?,?,0, NULL);";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $mot, PDO::PARAM_STR);
        $req->bindValue(2, User::$id, PDO::PARAM_INT);
        $req->bindValue(3, time(), PDO::PARAM_INT);
        $req->execute();
    }

    function valider_mot() {
        
    }

    function supprimer_mot() {
        
    }

    function liste_mots($posteur = false, $nb = false) {
        $condition = ($posteur) ? "WHERE proposeur = '{$posteur}'" : "";
        $limit = ($nb) ? "limit 0,{$nb}" : "";
        $sql = "SELECT * FROM mots {$condition} ORDER BY id DESC {$limit}";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function renvoie_mot_aléatoire() {
        $sql = "SELECT * FROM mots ORDER BY RAND() LIMIT 0,1";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);
    }

    /**
     *  verifie que le mot quotidien n'a pas encore été assigné
     *  et dans ce cas assigne un mot aléatoire, dans le cas ou le mot aurait déja été
     *  désigné il est renvoyé au motController
     *  @return object Objet des infos du mot assigné pour le type
     */
    function assigne_mot() {

        $id_user = User::$id;
        $heure = time();
        $jour = date("z", $heure);
        $an = date("Y", $heure);

        // on verifie si le mot n'a pas déja été assigné pour aujourd'hui
        $sqla = "SELECT * FROM mot_du_jour mdj LEFT JOIN mots m 
                    ON mdj.id_mot=m.id 
                    WHERE annee ='{$an}'
                    AND jour='{$jour}' 
                    AND id_user='{$id_user}'";
        $res = $this->pdo->query($sqla)->fetch(PDO::FETCH_OBJ);

        if ($res === false) {

            $mot = $this->renvoie_mot_aléatoire();
            $id_mot = $mot->id;

            $hash = substr(md5($id_mot . $jour . $an . $id_user), 10);

            $sqlb = "INSERT INTO mot_du_jour VALUES (?,?,?,?,?,?,0,NULL)";

            $req = $this->pdo->prepare($sqlb);
            $req->bindValue(1, $id_mot);
            $req->bindValue(2, $id_user);
            $req->bindValue(3, $heure);
            $req->bindValue(4, $jour);
            $req->bindValue(5, $an);
            $req->bindValue(6, $hash, PDO::PARAM_STR);
            $req->execute();

            return $this->pdo->query($sqla)->fetch(PDO::FETCH_OBJ);
            ;
        } else {
            return $res;
        }
    }

    #todo penser a séparer la gestion des mots de la base de la gestion des mots attribués pour jouer

    function historique_mots_perso() {
        $jour = date("z", time());
        $an = date("Y", time());
        $id_user = User::$id;
        $sql = "SELECT heure,mot,id_resultat 
                FROM mot_du_jour mdj 
                LEFT JOIN mots m
                ON mdj.id_mot=m.id
                WHERE mdj.id_user='{$id_user}'
                AND mdj.id NOT IN
                    (SELECT id FROM mot_du_jour 
                    WHERE id_user='{$id_user}' AND jour='{$jour}' AND annee='{$an}')
                ORDER BY mdj.id DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function renvoie_infos_mot_du_jour() {
        $id_user = User::$id;
        $jour = date("z", time());
        $sql = "SELECT * FROM mot_du_jour mdj LEFT JOIN mots m 
                ON mdj.id_mot=m.id 
                WHERE mdj.id_user='{$id_user}' AND jour='{$jour}'";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);
    }

    function enregistrer_resultat_du_gars($phrase, $capture) {
        $heure = time();
        $id_user = User::$id; // on met ca pour dire d'avoir un id correct
        $sql = "INSERT INTO resultats VALUES ('{$heure}','{$phrase}','{$capture}',0,'{$id_user}','',null)";
        $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();
    }

    function maj_mdj_attente_validation($id, $h) {
        $sql = "UPDATE mot_du_jour SET id_resultat='{$id}' WHERE hash='{$h}'";
        return $this->pdo->exec($sql);
    }

    function ce_resultat_est_il_valide($id){
        $sql = "SELECT valide FROM resultats WHERE id='{$id}'";
        $res = $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);
        return $res->valide;
    }
}

?>
