<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user03')]
class User{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    private int $id;

    #[ORM\Column(type:'string')]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $enable;

    #[ORM\Column(type: 'datetime')]
    private \Datetime $birthdate;

    #[ORM\Column(type: 'text')]
    private string $address;


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



}



?>