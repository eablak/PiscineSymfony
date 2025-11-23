<?php

namespace App\Form;

class PostForm{

    private $id;
    private $title;
    private $content;
    private $created;
    private $author;

    public function setTitle($title){
        $this->title = $title;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function setCreated($created){
        $this->created = $created;
    }

    public function setAuthor($author){
        $this->author = $author;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getContent(){
        return $this->content;
    }

    public function getCreated(){
        return $this->created;
    }

    public function getAuthor(){
        return $this->author;
    }

}


?>