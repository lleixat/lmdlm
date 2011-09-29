<?php

/**
 * Classe qui centralise les données de l'user loggé
 *
 * @author rudak
 */
class User {

    private $user;
    private $mail;
    private $first;
    private $last;
    private $etab;
    private $promo;
    private $image;
    private $id;

    function __construct($id) {
        $obj = new UserModel();
        $infos = $obj->get_userInfos($id);

        $this->user = $infos->user;
        $this->mail = $infos->mail;
        $this->first = $infos->first;
        $this->last = $infos->last;
        $this->etab = $infos->etab;
        $this->promo = $infos->promo;
        $this->image = $infos->image;
        $this->id = $id;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getFirst() {
        return $this->first;
    }

    public function setFirst($first) {
        $this->first = $first;
    }

    public function getLast() {
        return $this->last;
    }

    public function setLast($last) {
        $this->last = $last;
    }

    public function getEtab() {
        return $this->etab;
    }

    public function setEtab($etab) {
        $this->etab = $etab;
    }

    public function getPromo() {
        return $this->promo;
    }

    public function setPromo($promo) {
        $this->promo = $promo;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    function getId(){
        return $this->id;
    }

}

?>
