<?php

include_once "HotBeverage.php";

class Coffee extends HotBeverage{

    private $description = "Coffee, beverage brewed from the roasted and ground seeds of the tropical evergreen coffee plants of African origin.\n";
    private $comment = "Coffee consumption has been associated with various health benefits and health risks.\n";

    public function __construct(){
        parent::__construct("Coffee",10,3.3);
    }

    public function getDescription(){
        return $this->description;
    }

    public function getComment(){
        return $this->comment;
    }

    public function __destruct(){

    }

}


?>