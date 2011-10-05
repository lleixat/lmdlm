<?php

// title est description de la page par defaut
define("TITLE","Le Mot De La Mort");
define("DESCRIPTION","La description du truc");

// mode d'utilisation dev/prod
define("MODE","dev");

// une clé de cryptage
define("CLE_SHA_PERSO","68bb044c0cc98d78bb4e543565347b48");

// taille d'upload max en Mio
$taille_max_upload_avatar = (1024*1024*5);
define("TAILLE_MAX_UPLOAD",$taille_max_upload_avatar);

/*
 * debug
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
*/

if($_SERVER['SERVER_NAME'] == "localhost"){
    // l'url de base a placer dans le head pour qu'il trouve toujours l'arbo parente (artificiellement)
    define("TYPE_ACCES_BASE","local");
    define("URL_BASE","http://localhost/lmdlm/");
} else {
        define("TYPE_ACCES_BASE","distant");
    define("URL_BASE","http://".$_SERVER['SERVER_NAME']."/lmdlm/");
}

# todo urlbase a revoir pour la production
?>
