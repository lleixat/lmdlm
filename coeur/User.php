<?php

/**
 * Classe qui centralise les données de l'user loggé
 *
 * @author rudak
 */
class User {

    static $user;
    static $user_url;
    static $mail;
    static $first;
    static $last;
    static $etab;
    static $promo;
    static $image;
    static $id;
    static $rang;

    function __construct($id = false) {
        if($id == false)
            return false;
        $obj = new UserModel();
        $infos = $obj->get_userInfos($id);
        self::$user = $infos->user;
        self::$mail = $infos->mail;
        self::$first = $infos->inscription;
        self::$last = $infos->last;
        self::$etab = $infos->type_etab;
        self::$promo = $infos->promo;
        self::$image = $infos->image;
        self::$rang = $infos->rang;
        self::$id = $id;
        self::$user_url = $this->formatrewriting(self::$user);
    }

    function formatrewriting($chaine) {
        //les accents
        $chaine = trim($chaine);
        $chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        //les caracètres spéciaux (aures que lettres et chiffres en fait)
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        $chaine = trim($chaine, "-");
        return $chaine;
    }

}

?>
