<?php

namespace App\Entity;

class UserForm{

    private $username;
    private $name;
    private $email;
    private $enable;
    private $birthdate;
    private $address;

    public function setUserName($username){
        $this->username = $username;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setEnable($enable){
        $this->enable = $enable;
    }

    public function setBirthDate($birthdate){
        $this->birthdate = $birthdate;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    public function getUserName(){
        return $this->username;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getEnable(){
        return $this->enable;
    }

    public function getBirthDate(){
        return $this->birthdate;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getId(){
        return $this->id;
    }

}


?>