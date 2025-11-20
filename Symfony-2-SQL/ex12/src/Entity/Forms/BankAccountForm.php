<?php

namespace App\Entity\Forms;

class BankAccountForm{

    private $user_id;
    private $account_id;
    private $bank_name;
    private $password;
    private $person = null;

     public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAccountId(): ?string
    {
        return $this->account_id;
    }

    public function setAccountId(string $account_id): static
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bank_name;
    }

    public function setBankName(string $bank_name): static
    {
        $this->bank_name = $bank_name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson($person): static
    {
        $this->person = $person;
        return $this;
    }

}


?>