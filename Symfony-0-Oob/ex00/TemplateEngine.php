<?php

class TemplateEngine{


    function createFile($fileName, $templateName, $parameters){

        $read_file = fopen($templateName, "r");
        $write_file = fopen($fileName, "w");
        
        if ($read_file){
            
            $pattern = "/\{(.*?)\}/";
            $replacment_index = 0;

            while(($line = fgets($read_file)) !== false){

                if (preg_match($pattern, $line)){
                    $replacment = $parameters[$replacment_index];
                    $new_line =  preg_replace($pattern, $replacment ,$line);
                    fwrite($write_file, $new_line);
                    $replacment_index++;
                }else{
                    fwrite($write_file, $line);
                }

            }
            fclose($read_file);
        }else{
            echo "Failed to open file";
        }
    }

}


?>