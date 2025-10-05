<?php

class HotBeverage{

    protected $name;
    protected $price;
    protected $resistance;


    public function __construct($_name , $_price, $_resistance){
        $this->name = $_name;
        $this->price = $_price;
        $this->resistance = $_resistance;
    }

    public function getName(){
        return $this->name;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getResistance(){
        return $this->resistance;
    }


    public function __destruct(){

    }
}


?>