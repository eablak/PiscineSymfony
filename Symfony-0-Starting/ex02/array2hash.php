<?php

function array2hash($array){

    $hash = [];

    if (count($array)){
        foreach($array as $arr){
            $hash[$arr[1]] = $arr[0];
        }
    }

    echo $hash;

    return $hash;
}

?>