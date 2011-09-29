<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author rudak
 */
class Model {

    protected $error;
    private $baseConf = array();
    protected $tables;
    static $connexion;
    protected $pdo;

    function __construct() {

        // Si la connection n'est pas encore crée alors on la crée
        if (!is_object(self::$connexion)) {

            // on choppe les infos de config base dans la classe confDB
            $this->baseConf = ConfDB::$acces['local'];
            try {
                $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); // force la conection en utf-8
                self::$connexion = new PDO('mysql:host=' . $this->baseConf['hote'] . ';dbname=' . $this->baseConf['base'], $this->baseConf['user'], $this->baseConf['pass'], $option);
                if (MODE == "dev") {
                    // les erreurs SQL s'affichent
                    self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                    $this->pdo = self::$connexion;
                }
            } catch (Exception $e) {
                die("Ohh ! Plantage du serveur !");
            };
        } else {
            // conexion pdo déja créé (dans la statique) donc on a juste a aller la chercher
            $this->pdo = self::$connexion;
        }
        $this->tables = ConfDB::$acces['local']['tables'];
    }

    function set_error($txt) {
        $this->error = $txt;
    }

    function get_error() {
        return $this->error;
    }

    function prp($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

?>
