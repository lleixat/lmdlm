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
                "TABLE_USERS" => "users",
                "TABLE_TYPE_ETAB" => "type_etab"
        )),
        "distant" => array(
            "hote" => "",
            "base" => "",
            "user" => "",
            "pass" => "",
            "tables" => array(
                "TABLE_ETAB"  => "etab",
                "TABLE_PROMO" => "promo",
                "TABLE_USERS" => "users"
        ))
    );

}

?>