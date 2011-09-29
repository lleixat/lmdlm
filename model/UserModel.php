<?php

class UserModel extends Model {

    /**
     *
     * @param string $user le pseudo du type
     * @param string $pass le mot de passe du type
     * @return id Renvoie id si ok ou false si pas ok
     */
    function controle_identifiants($user, $pass) {
        $sql = "SELECT id  FROM " . $this->tables['TABLE_USERS'] . " WHERE user=? AND password=?";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $user, PDO::PARAM_STR);
        $req->bindValue(2, sha1($pass . CLE_SHA_PERSO), PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_OBJ);

        if($result->id > 0){
            return $result->id;
        } else {
            $this->set_error("Aucune correspondance");
            return false;
        }
    }

    /**
     *
     * @param type $id l'id du type qui nous interresse
     * @return object retourne un objet avec toutes les infos du type
     */
    function get_userInfos($id){

        $sql = "SELECT * FROM " . $this->tables['TABLE_USERS'] . " WHERE id=?";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $id, PDO::PARAM_INT);
        $req->execute();

        $infos = $req->fetchAll(PDO::FETCH_OBJ);
        return $infos[0];
    }

}

?>
