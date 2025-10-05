<?php

include_once "HotBeverage.php";

class TemplateEngine{


    function collect_attr($reflection, $text){

        $attr = [];
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $func_name = "get" . ucfirst($property->getName());
            $value = $reflection->getMethod($func_name)->invoke($text);
            $attr[$property->getName()] = $value;
        }
        return $attr;
    }



    function createFile(HotBeverage $text){
        
        $file = fopen("template.html", "r");
        if (!$file)
            return ;
        $reflection = new ReflectionClass($text);
        $file_name = $reflection->getName() . ".html";
        $write_file = fopen($file_name, "w");

        $attr = $this->collect_attr($reflection, $text);

        if ($file){
            
            $pattern = "/\{(.*?)\}/";

            while(($line = fgets($file)) !== false){

                if (preg_match($pattern, $line, $matches)){

                    $matched_word = $matches[1];
                    if ($matched_word == "nom")
                        $matched_word = "name";
                    $new_value = $attr[$matched_word];
                    $new_line =  preg_replace($pattern, $new_value ,$line);
                    fwrite($write_file, $new_line);
                }else{
                    fwrite($write_file, $line);
                }

            }
            fclose($file);
        }
    }
}

?>