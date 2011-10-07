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
            
            $hash = md5($id_mot.$jour.$an.$id_user);
                        
            $sqlb = "INSERT INTO mot_du_jour VALUES (?,?,?,?,?,?,0,NULL)";

            $req = $this->pdo->prepare($sqlb);
            $req->bindValue(1, $id_mot);
            $req->bindValue(2, $id_user);
            $req->bindValue(3, $heure);
            $req->bindValue(4, $jour);
            $req->bindValue(5, $an);
            $req->bindValue(6, $hash,  PDO::PARAM_STR);
            $req->execute();

            return $this->pdo->query($sqla)->fetch(PDO::FETCH_OBJ);;
        } else {
            return $res;
        }
    }

}

?>