<?php

class Text{

    public $parameters = [];

    public function __construct($str_array){
        $this->parameters = $str_array;
    }

    public function __destruct(){
    }


    function append($new_data){
        array_push($this->parameters, $new_data);
        // print_r($this->parameters);
    }


    function readData(){
        
        $html_p = "";
        foreach($this->parameters as $param){
            $html_p .= "<p>" . $param . "</p>" . "\n";
        }
        return $html_p;
    }


}

?>