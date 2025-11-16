<?php

namespace App\Entity;

class UserForm{

    private $username;
    private $name;
    private $email;
    private $enable;
    private $birthdate;
    private $marital_status;

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

    public function setMaritalStatus($marital_status){
        $this->marital_status = $marital_status;
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

    public function getId(){
        return $this->id;
    }

    public function getMaritalStatus(){
        return $this->marital_status;
    }

}


?>