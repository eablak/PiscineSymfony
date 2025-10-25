<?php

namespace App\Entity;

class MessageForm{

    private $message;
    private $time;
    
    
    public function setMessage($message){
        return $this->message = $message;
    }
    
    public function getMessage(){
        return $this->message;
    }

    public function setTime($time){
        $this->time = $time;
    }

    public function getTime(){
        return $this->time;
    }
}



?>