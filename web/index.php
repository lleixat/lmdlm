<?php
session_start();
require 'base.php'; // toutes les configs de base (constantes repertoires etc)

if(isset($_SESSION['login']) && $_SESSION['login'] === true && !empty($_SESSION['id_user'])){
    $user = new User($_SESSION['id_user']);
}

new Loader();
?>
