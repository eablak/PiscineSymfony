<?php

include_once "HotBeverage.php";

class Tea extends HotBeverage{

    private $description = "Tea, beverage produced by steeping in freshly boiled water the young leaves and leaf buds of the tea plant, Camellia sinensis.\n";
    private $comment = "The best-known constituent of tea is caffeine, which gives the beverage its stimulating character but contributes only a little to colour, flavour, and aroma.\n";

    public function __construct(){
        parent::__construct("Tea",4,0.6);
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