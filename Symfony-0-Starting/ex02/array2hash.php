<?php

function array2hash($array){

    $hash = [];

    if (count($array)){
        foreach($array as $arr){
            $hash[$arr[0]] = $arr[1];
        }
    }

    echo $hash;

    return $hash;
}

?>