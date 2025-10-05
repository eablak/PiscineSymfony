<?php

class Elem{

    public $element;
    public $content;
    public $all = [];

    function check_html_tag($element){
        $allowed = ["meta", "img", "hr", "br", "html", "head", "body", "title", "h1", "h2", "h3", "h4", "h5", "h6", "p", "span", "div"];

        foreach ($allowed as $allow){
            if ($allow == $element)
                return True;
        }
        return False;
    }

    function __construct($element, $content=null){
        if ($this->check_html_tag($element)){
            $this->element = $element;
            $this->content = $content;
        }else{
            echo "Not allowed html tag\n";
            return ;
        }
    }
 
    function pushElement(Elem $elem){
        $this->all[] = $elem;
    }


    function getHTML($repeat = 0){
        
        $tab = str_repeat("    ", $repeat);
        $html = "$tab<{$this->element}>";

        if ($this->content)
            $html .= $this->content;

        foreach ($this->all as $child)
            $html .= "\n" . $child->getHTML($repeat + 1);

        if ($this->content === '')
            $html .= "{$inreperdent}";
        $html .= "</{$this->element}>\n";
        return $html;
    }

}


?>