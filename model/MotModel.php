<?php

class MotModel extends Model {
    
    function ajouter_mot($mot){
        $sql = "INSERT INTO mots VALUES (?,?,?,0, NULL);";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1,$mot,         PDO::PARAM_STR);
        $req->bindValue(2,  User::$id,  PDO::PARAM_INT);
        $req->bindValue(3, time(),      PDO::PARAM_INT);
        $req->execute();
    }
    
    function valider_mot(){
        
    }
    
    function supprimer_mot(){
        
    }
    
    function liste_mots($posteur = false,$nb = false){
        $condition = ($posteur)?"WHERE proposeur = '{$posteur}'":"";
        $limit = ($nb)?"limit 0,{$nb}":"";
        $sql = "SELECT * FROM mots {$condition} ORDER BY id DESC {$limit}";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}

?>
