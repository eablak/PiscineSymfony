<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'userorm')]
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
    private Datetime $birthdate;

    #[ORM\Column(type: 'text')]
    private string $address;
}



?>