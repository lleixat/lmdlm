<?php

class ConfDB {

    static $acces = array(
        "local" => array(
            "hote"   => "localhost",
            "base"   => "lmdlm",
            "user"   => "root",
            "pass"   => "geekinside",
            "tables" => array(
                "TABLE_ETAB"             => "etab",
                "TABLE_PROMO"            => "promo",
                "TABLE_USERS"            => "users",
                "TABLE_TYPE_ETAB"        => "type_etab",
                "TABLE_UNVALIDATED_USER" => "unvalidated_user",
                "TABLE_MDJ"              => "mot_du_jour",
                "TABLE_MOTS"             => "mots",
                "TABLE_RESULTATS"        => "resultats"
            )),
        "distant" => array(
            "hote"   => "",
            "base"   => "",
            "user"   => "",
            "pass"   => "",
            "tables" => array(
                "TABLE_ETAB"             => "etab",
                "TABLE_PROMO"            => "promo",
                "TABLE_USERS"            => "users",
                "TABLE_TYPE_ETAB"        => "type_etab",
                "TABLE_UNVALIDATED_USER" => "unvalidated_user",
                "TABLE_MDJ"              => "mot_du_jour",
                "TABLE_MOTS"             => "mots",
                "TABLE_RESULTATS"        => "resultats"
            ))
        );

}

?>
