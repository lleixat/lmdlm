<?php

class UserModel extends Model {

    /**
     *
     * @param string $user le pseudo du type
     * @param string $pass le mot de passe du type
     * @return id Renvoie id si ok ou false si pas ok
     */
    function controle_identifiants($user, $pass) {
        $sql = "SELECT id  FROM " . $this->tables['TABLE_USERS'] . " 
                    WHERE user=? AND password=?";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $user, PDO::PARAM_STR);
        $req->bindValue(2, sha1($pass . CLE_SHA_PERSO), PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_OBJ);

        if (isset($result->id) && $result->id > 0) {
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
    function get_userInfos($id) {

        // modifier tout ca avec les tables du fichier ConfDB.php

        $sql = "SELECT user, mail, image, rang, first
                inscription , last, u.id, t.nom
                type_etab , ville, p.nom promo, annee
                FROM (
                (
                " . $this->tables['TABLE_USERS'] . " u
                LEFT JOIN " . $this->tables['TABLE_ETAB'] . " e 
                    ON u.etab = e.id
                )
                LEFT JOIN " . $this->tables['TABLE_PROMO'] . " p 
                    ON u.promo = p.id
                )
                LEFT JOIN " . $this->tables['TABLE_TYPE_ETAB'] . " t 
                    ON e.type = t.id
                WHERE u.id =?";

        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $id, PDO::PARAM_INT);
        $req->execute();

        $infos = $req->fetchAll(PDO::FETCH_OBJ);
        if (count($infos) > 0)
            return $infos[0];
        else
            return false;
    }

    function enregistrer_new_user($i = false) {
        if ($i === false)
            return FALSE;

        $sql_etab = "INSERT INTO " . $this->tables['TABLE_ETAB'] . " 
                        VALUES (?, ?, NULL)";
        $req = $this->pdo->prepare($sql_etab);
        $req->bindValue(1, $i['insc_type_etab'], PDO::PARAM_INT);
        $req->bindValue(2, $i['insc_ville_etab'], PDO::PARAM_STR);
        $req->execute();
        $id_etab = $this->pdo->lastInsertId();
        $req->closeCursor();

        $sql_promo = "INSERT INTO " . $this->tables['TABLE_PROMO'] . " 
                        VALUES (?,?,?,NULL)";
        $req = $this->pdo->prepare($sql_promo);
        $req->bindValue(1, $i['insc_promo_etab'], PDO::PARAM_STR);
        $req->bindValue(2, date("Y", time()), PDO::PARAM_INT);
        $req->bindValue(3, $id_etab, PDO::PARAM_INT);
        $req->execute();
        $id_promo = $this->pdo->lastInsertId();
        $req->closeCursor();

        $sql_user = "INSERT INTO " . $this->tables['TABLE_USERS'] . " 
                        VALUES (?, ?, ?, ?,1, ?, ?, ?, ?, NULL)";
        $req = $this->pdo->prepare($sql_user);
        $req->bindValue(1, $i['insc_user'], PDO::PARAM_STR);
        $req->bindValue(2, sha1($i['insc_pass'] . CLE_SHA_PERSO), PDO::PARAM_STR);
        $req->bindValue(3, $i['insc_mail'], PDO::PARAM_STR);
        $req->bindValue(4, $i['insc_image'], PDO::PARAM_STR);
        $req->bindValue(5, time(), PDO::PARAM_INT);
        $req->bindValue(6, time(), PDO::PARAM_INT);
        $req->bindValue(7, $id_etab, PDO::PARAM_INT);
        $req->bindValue(8, $id_promo, PDO::PARAM_INT);
        $req->execute();
        $id_user = $this->pdo->lastInsertId();
        $req->closeCursor();

        return $id_user;
    }

    function ajoute_unvalidated_user($id, $clef) {
        $sql = "INSERT INTO " . $this->tables['TABLE_UNVALIDATED_USER'] . " 
                    VALUES (?,?,?,NULL)";
        $req = $this->pdo->prepare($sql);

        $req->bindValue(1, $id, PDO::PARAM_INT);
        $req->bindValue(2, $clef, PDO::PARAM_STR);
        $req->bindValue(3, (time() + 24 * 3600), PDO::PARAM_INT);
        $req->execute();
        return true;
    }

    /**
     *
     * @return array renvoie les types d'etablissements
     */
    function get_type_etab() {
        $sql = "SELECT * FROM " . $this->tables['TABLE_TYPE_ETAB'] . "";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function liste_des_membres($valide = true) {
        if ($valide === true) {
            $sql = "SELECT user, mail, image,first
                inscription , last, u.id, t.nom
                type_etab , ville, p.nom promo, annee
                FROM (
                (
                " . $this->tables['TABLE_USERS'] . " u
                LEFT JOIN " . $this->tables['TABLE_ETAB'] . " e 
                    ON u.etab = e.id
                )
                LEFT JOIN " . $this->tables['TABLE_PROMO'] . " p 
                    ON u.promo = p.id
                )
                LEFT JOIN " . $this->tables['TABLE_TYPE_ETAB'] . " t 
                    ON e.type = t.id
                    ORDER BY u.id DESC";
        } else {
            $sql = "SELECT * FROM " . $this->tables['TABLE_UNVALIDATED_USER'];
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function maj_last_viste($id) {
        $sql = "UPDATE " . $this->tables['TABLE_USERS'] . " SET last='" . time() . "' 
                WHERE id='{$id}'";
        $this->pdo->exec($sql);
    }

    function compte_resultats_valides($id_user) {
        $sql = "SELECT COUNT(*) nb FROM " . $this->tables['TABLE_MDJ'] . " mdj 
                    LEFT JOIN " . $this->tables['TABLE_RESULTATS'] . " r
                        ON mdj.id_resultat=r.id
                            WHERE r.valide='1' AND mdj.id_user='{$id_user}'";

        $res = $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);
        return $res->nb;
    }

    function compte_resultats_invalides($id_user) {
        $sql = "SELECT COUNT(*) nb FROM " . $this->tables['TABLE_MDJ'] . " mdj 
                    LEFT JOIN " . $this->tables['TABLE_RESULTATS'] . " r
                        ON mdj.id_resultat=r.id
                            WHERE r.valide='9' AND mdj.id_user='{$id_user}'";

        $res = $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);
        return $res->nb;
    }

    function liste_par_score() {
        $sql = "SELECT user, u.id,(
                SELECT count( * ) score
                FROM (
                " . $this->tables['TABLE_USERS'] . " u2
                LEFT JOIN " . $this->tables['TABLE_MDJ'] . " m2 
                    ON u2.id = m2.id_user
                )
                LEFT JOIN " . $this->tables['TABLE_RESULTATS'] . " r2 
                    ON m2.id_resultat = r2.id
                WHERE r2.valide =1
                AND m2.id_user = u.id
                )score
                FROM " . $this->tables['TABLE_USERS'] . " u
                LEFT JOIN " . $this->tables['TABLE_MDJ'] . " m 
                    ON u.id = m.id_user
                GROUP BY u.id
                ORDER BY score DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);

        /*
         * peut etre améliorée en incluant une condition d'ordre.
         * faire un autre select qui compte le nombre total de mot joués
         * donnant la priorité a celui qui en a le plus pour un score egal
         * et ensuite a celui qui était inscrit avant l'autre
         * 
         * ensuite on peut inclure ceux qui ont zéro via UNION en les classant 
         * par ordre de mots joués et d'ancieneté.
         * bordel...déja que j'ai mis 1 heure pour pondre cette requete...   :-)
         */
    }

    function liste_membres() {
        $sql = "SELECT user,rang,u.id FROM " . $this->tables['TABLE_USERS']. " u LEFT JOIN unvalidated_user un ON u.id=un.user_id";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function banMembre($id) {
        $sql = "UPDATE " . $this->tables['TABLE_USERS'] . " SET rang=0 WHERE id=" . $id;
        $this->pdo->exec($sql);
    }

    function addMembre($id) {
        $sql = "UPDATE " . $this->tables['TABLE_USERS'] . " SET rang=2 WHERE id=" . $id;
        $this->pdo->exec($sql);
    }

    function addAdmin($id) {
        $sql = "UPDATE " . $this->tables['TABLE_USERS'] . " SET rang=5 WHERE id=" . $id;
        $this->pdo->exec($sql);
    }

    function validerMembre($hash) {
        $sql = "UPDATE " . $this->tables['TABLE_USERS'] . " u 
                LEFT JOIN " . $this->tables['TABLE_UNVALIDATED_USER'] . "  un 
                ON u.id = un.user_id SET u.rang=2 
                WHERE un.hash=?";
        $req = $this->pdo->prepare($sql);
        $req->bindValue(1, $hash, PDO::PARAM_STR);
        $req->execute();

        $sql2 = "DELETE FROM " . $this->tables['TABLE_UNVALIDATED_USER'] . " WHERE hash=?";
        $req2 = $this->pdo->prepare($sql2);
        $req2->bindValue(1, $hash, PDO::PARAM_STR);
        $req2->execute();
    }

    function histo_membre($id)
    {
        /**
         * Liste les résultats d'un membre donné
         * @param user id
         * return array
         */
        $sql = "SELECT id_user
                     , mot
                     , u.user
                     , valide
                     , capture
                     , phrase
                     , heure
                  FROM " . $this-> tables['TABLE_RESULTATS'] . " r
                  LEFT JOIN " . $this->tables['TABLE_USERS'] . " u
                  ON r.id_user=u.id
                  WHERE id_user= {$id}
                  ORDER BY heure DESC
                  LIMIT 0,30 ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

}


?>
