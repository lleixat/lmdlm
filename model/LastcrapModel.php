<?php


class LastCrap extends Model {


    function dernier_membres_inscrits($User_id=null, $limit=30)
    {
        /**
         * Renvoie la liste des derniers membres inscrits depuis la dernière
         * connexion de l'utilisateur, triés du plus récent au plus ancien
         *
         * @param1  user id
         * @param2  max table rows (defaut 30)
         * @return  array
         */
        $sql="SELECT id
                   , user
                   , first
                   , etab
                FROM " . $this->tables['TABLE_USERS'] . " u
               WHERE (SELECT last
                         FROM " . $this->tables['TABLE_USERS'] . "
                        WHERE id  =  {$User_id})< first
                 AND u.id != {$User_id}
               ORDER BY first DESC LIMIT {$limit}";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }


    function dernier_mots_valides($User_id=null, $limit=30)
    {
        /**
         * Renvoie la liste des derniers mots proposés par le joueur, validés par 
         * un admin depuis la dernière connexion de cet utilisateur, triés du plus
         * récent au plus ancien.
         *
         * @param1  user id
         * @param2  limit table row (defaut 30)
         * @return  array
         */
        $sql="SELECT mot
                   , m.proposeur
                   , m.id id_mot
                   , m.date
                   , u.user
                   , u.id id_user
                FROM " . $this->tables['TABLE_MOTS'] . " m
                LEFT JOIN " . $this->tables['TABLE_USERS'] . " u
                  ON m.proposeur     = u.id
               WHERE valide          = '1'
                 AND u.id            = {$User_id}
                 AND m.date          > u.last
               ORDER BY m.date DESC LIMIT {$limit}";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

}


?>
