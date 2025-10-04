<?php

function get_elements($file){

    $table_elements = [];

    if ($file){
        while(($line = fgets($file)) !== false){

            list($element, $value_line) = explode("=", $line);
            $element = trim($element);
            $values = array_map("trim", explode(",", $value_line));

            $table_elements[$element] = $values;
        }
    }
    return($table_elements);
}


function table_positioning($elements){

    $table = [];

    for ($y=0; $y<7; $y++){
        $row = [];
        for($x=0; $x<18; $x++){
            $row[] = "";
        }
        $table[] = $row;
    }

    foreach($elements as $key=>$value){
        list($position,$pos_num) = explode(":", $value[0]);
        list($number, $num_num) = explode(":", $value[1]);
        list($small_k, $small_num)    = explode(":", $value[2]);
        list($molar_k, $molar_num)    = explode(":", $value[3]);
        list($elec_k, $electron_num)  = explode(":", $value[4]);

        if ($num_num == 1 || $num_num == 2) {
            $row = 0;
        } elseif ($num_num >= 3 && $num_num <= 10) {
            $row = 1;
        } elseif ($num_num >= 11 && $num_num <= 18) {
            $row = 2;
        } elseif ($num_num >= 19 && $num_num <= 36) {
            $row = 3;
        } elseif ($num_num >= 37 && $num_num <= 54) {
            $row = 4;
        } elseif ($num_num >= 55 && $num_num <= 86) {
            $row = 5;
        } else {
            $row = 6;
        }

        $table[$row][$pos_num] = ["name" => $key, "number" => $num_num, "small" => $small_num,"molar" => $molar_num, "electron" => $electron_num];
    }

    return $table;
}


function generate_html($table){
    
    $html_file = "mendeleiev.html";

    $html = "<!DOCTYPE html>\n";
    $html .= "<html lang=\"en\">\n";
    $html .= "<head>\n";
    $html .= "\t<meta charset=\"UTF-8\">\n";
    $html .= "\t<title>Periodic Table</title>\n";
    $html .= "</head>\n<body>\n";
    $html .= "\t<h1>Periodic Table</h1>";
    $html .= '<table style="border-collapse: collapse;">';

    foreach($table as $row){

        $html .= '<tr>';

        foreach ($row as $cell){
            if ($cell === "" || $cell === null) {
                $html .= "<td></td>";
            } else {
                $name = $cell["name"];
                $number = $cell["number"];
                $small = $cell["small"];
                $molar = $cell["molar"];
                $electron = $cell["electron"];
    
                $html .= "<td style='border: 1px solid black; padding:10px'>";
                $html .= "<h4>{$name}</h4>";
                $html .= "<ul>";
                $html .= "<li>No {$number}</li>";
                $html .= "<li>{$small}</li>";
                $html .= "<li>{$molar}</li>";
                $html .= "<li>{$electron} electron</li>";
                $html .= "</ul></td>";
            }
        }
        $html .= "</tr>";
    }

    $html .= "</table></body></html>";
    file_put_contents($html_file, $html);
}


function main($file_name){
    
    $file = fopen($file_name, "r");
    if($file){
        $elements = get_elements($file);
        // print_r($elements);
        $table = table_positioning($elements);
        // print_r($table);
        generate_html($table);
    }else{
        echo "File not found\n";
    }
}

main("ex06.txt");

?>