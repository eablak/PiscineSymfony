<?php

function array2hash_sorted($array){

    $hash = [];

    if(count($array)){
        foreach($array as $arr){
            $hash[$arr[0]] = $arr[1];
        }
    }

    uksort($hash, function($a, $b) {
        return strcmp($b, $a);
    });
    
    return ($hash);
}

?>