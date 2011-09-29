<?php

class ConfDB {

    static $acces = array(
        "local" => array(
            "hote" => "localhost",
            "base" => "lmdlm",
            "user" => "root",
            "pass" => "",
            "tables" => array(
                "TABLE_ETAB"  => "etab",
                "TABLE_PROMO" => "promo",
                "TABLE_USERS" => "users"
        )),
        "distant" => array(
            "hote" => "sql.free.fr",
            "base" => "rudak",
            "user" => "rudak",
            "pass" => "",
            "tables" => array(
                "TABLE_ETAB"  => "etab",
                "TABLE_PROMO" => "promo",
                "TABLE_USERS" => "users"
        ))
    );

}

?>