<?php

include "MyException.php";


class Elem{

    public $element;
    public $content;
    public $attributes = [];
    public $all = [];

    function check_html_tag($element){
        $allowed = ["meta", "img", "hr", "br", "html", "head", "body", "title", "h1", "h2", "h3", "h4", "h5", "h6", "p", "span", "div", "table", "tr", "th", "td", "ul", "ol", "li"];

        if(in_array($element, $allowed))
            return True;
        return False;
    }

    function __construct($element, $content=null, $attributes=null){
        if ($this->check_html_tag($element)){
            $this->element = $element;
            $this->content = $content;
            $this->attributes = $attributes;
        }else{
            throw new MyException("Not allowed html tag\n");
        }
    }
 
    function pushElement(Elem $elem){
        $this->all[] = $elem;
    }


    function get_attr(){
        $line = "";
        foreach($this->attributes as $key=>$value){
            $line .= "$key=\"$value\" ";
        }
        return $line;
    }



    function getHTML($repeat = 0){

        $void_tags = ["meta", "img", "hr", "br"];
        $tab = str_repeat("    ", $repeat);
        $tab_close = @str_repeat("    ", $repeat-1);
        $html = "$tab<$this->element";
        $line = "";


        if (!(empty($this->attributes))){
            $line = $this->get_attr();
            $html .= " $line>";
        }else{
            $html .= ">";
        }
        
        if (in_array($this->element, $void_tags)){
            $html = "$tab<{$this->element} $line/>\n$tab_close";
            return $html;
        }
        
        if ($this->content)
            $html .= $this->content;

        foreach ($this->all as $child)
            $html .= "\n" . $child->getHTML($repeat + 1);


        $html .= "</{$this->element}>\n$tab_close";

        return $html;
    }


    function check_parent_node(){

        if ($this->element != "html"){
            return false;
        }
        if (count($this->all) != 2){
            return false;
        }
        if ($this->all[0]->element != "head" || $this->all[1]->element != "body"){
            return false;
        }

        return true;
    }

    function check_head(){

        $head = $this->all[0];
        $title = 0;
        $meta = 0;

        if (count($head->all) < 2){
            return false;
        }
        
        foreach($head->all as $child){
            if ($child->element == "title")
                $title++;
            if ($child->element == "meta")
                $meta++;
        }

        if (!($title == 1 && $meta ==1))
            return false;

        return true;

    }

    function check_p($elem, $array){
        
        if (count($array)){
            foreach ($array as $arr){
                $this->check_p($arr->element, $arr->all);
                if ($arr->element == 'p' && count($arr->all)){
                    // print_r($arr->all);
                    return false;
                }
            }
        }

        return true;


    }



    function validPage(){
        
        // echo $this->element . "\n";
        // print_r($this->all);
        
       
        $this->check_parent_node();
        $this->check_head();
        $this->check_p($this->element, $this->all);




        // return true;
    }


}


?>