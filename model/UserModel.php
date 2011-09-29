<?php

class UserModel extends Model {

    function controle_identifiants($user, $pass) {
        $sql = "SELECT count(*) nb FROM " . $this->tables['TABLE_USERS'] . " WHERE user=? AND password=?";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $user, PDO::PARAM_STR);
        $req->bindValue(2, sha1($pass . CLE_SHA_PERSO), PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_OBJ);

        if($result->nb == 1){
            return true;
        } else {
            $this->set_error("Aucune correspondance");
            return false;
        }
    }

}

?>
