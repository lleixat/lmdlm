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

        if(isset($result->id) && $result->id > 0){
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

        // modifier tout ca avec les tables du fichier ConfDB.php

        $sql = "SELECT user, mail, image,first
                inscription , last, u.id, t.nom
                type_etab , ville, p.nom promo, annee
                FROM (
                (
                users u
                LEFT JOIN etab e ON u.etab = e.id
                )
                LEFT JOIN promo p ON u.promo = p.id
                )
                LEFT JOIN type_etab t ON e.type = t.id
                WHERE u.id =?";

        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $id, PDO::PARAM_INT);
        $req->execute();

        $infos = $req->fetchAll(PDO::FETCH_OBJ);
        if(count($infos)>0)
            return $infos[0];
        else
            return false;
    }


    function enregistrer_new_user($i = false){
        if($i === false)
            return FALSE;
        
        $sql_etab = "INSERT INTO etab VALUES (?, ?, NULL)";
        $req = $this->pdo->prepare($sql_etab);
        $req->bindValue(1, $i['insc_type_etab'], PDO::PARAM_INT);
        $req->bindValue(2, $i['insc_ville_etab'], PDO::PARAM_STR);
        $req->execute();
        $id_etab = $this->pdo->lastInsertId();
        $req->closeCursor();
                
        $sql_promo = "INSERT INTO promo VALUES (?,?,?,NULL)";
        $req = $this->pdo->prepare($sql_promo);
        $req->bindValue(1, $i['insc_promo_etab'], PDO::PARAM_STR);
        $req->bindValue(2, date("Y",time()), PDO::PARAM_INT);
        $req->bindValue(3, $id_etab, PDO::PARAM_INT);
        $req->execute();
        $id_promo = $this->pdo->lastInsertId();
        $req->closeCursor();
        
        $sql_user = "INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL)";
        $req = $this->pdo->prepare($sql_user);
        $req->bindValue(1, $i['insc_user'],  PDO::PARAM_STR);
        $req->bindValue(2, sha1($i['insc_pass'] . CLE_SHA_PERSO), PDO::PARAM_STR);
        $req->bindValue(3, $i['insc_mail'],  PDO::PARAM_STR);
        $req->bindValue(4, $i['insc_image'], PDO::PARAM_STR);
        $req->bindValue(5, time(), PDO::PARAM_INT);
        $req->bindValue(6, time(), PDO::PARAM_INT);
        $req->bindValue(7, $id_etab,  PDO::PARAM_INT);
        $req->bindValue(8, $id_promo, PDO::PARAM_INT);
        $req->execute();
        $id_user = $this->pdo->lastInsertId();
        $req->closeCursor();
        
        return $id_user;

    }
    
    function get_type_etab(){
        $sql = "SELECT * FROM type_etab";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

}

?>
