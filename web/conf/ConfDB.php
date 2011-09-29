<?php

class ConfDB {

    static $acces = array(
        "local" => array(
            "hote" => "localhost",
            "base" => "lmdlm",
            "user" => "root",
            "pass" => ""),
        "distant" => array(
            "hote" => "sql.free.fr",
            "base" => "rudak",
            "user" => "rudak",
            "pass" => "")
    );

    static $tables = array(
        "TABLE_ETAB"  => "etab",
        "TABLE_PROMO" => "promo",
        "TABLE_USERS" => "users"
    );

}

?>
