<?php

class AdminModel extends Model {

    function lister_resultats_a_valider() {
        $sql = "SELECT *
                FROM (
                (
                mot_du_jour mdj
                LEFT JOIN resultats r ON mdj.id_resultat = r.id
                )
                LEFT JOIN users u ON mdj.id_user = u.id
                )
                LEFT JOIN mots m ON mdj.id_mot = m.id
                WHERE mdj.id_resultat != '0'
                AND r.valide = '0'";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    function accepter_un_resultat($id) {
        $id_user = User::$id;
        $sql = "UPDATE resultats SET valide='1',validateur='{$id_user}' WHERE id='{$id}'";
        return $this->pdo->exec($sql);
    }

    function refuser_un_resultat($id) {
        $id_user = User::$id;
        $sql = "UPDATE resultats SET valide='9',validateur='{$id_user}' WHERE id='{$id}'";
        return $this->pdo->exec($sql);
    }

    function nombre_de_validation_en_attente() {
        $sql = "SELECT COUNT(*) nb FROM mot_du_jour mdj 
                LEFT JOIN resultats r
                ON mdj.id_resultat=r.id
                WHERE valide='0'";
        $res = $this->pdo->query($sql)->fetch(PDO::FETCH_OBJ);

        return $res->nb;
    }

    function accepter_un_Mot($id) {
        $sql = "UPDATE mots SET valide='1' WHERE id='{$id}'";
        $this->pdo->exec($sql);
    }

    function refuser_un_Mot($id) {
        $sql = "UPDATE mots SET valide='0' WHERE id='{$id}'";
        $this->pdo->exec($sql);
    }

}

?>
