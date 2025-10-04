<?php

$states = [
    'Oregon' => 'OR',
    'Alabama' => 'AL',
    'New Jersey' => 'NJ',
    'Colorado' => 'CO',
    ];

$capitals = [
    'OR' => 'Salem',
    'AL' => 'Montgomery',
    'NJ' => 'trenton',
    'KS' => 'Topeka',
];


function find_capital($state_name){

    global $states, $capitals;

    $abbr = $states[$state_name];

    foreach($capitals as $key=>$value){
        if ($abbr == $key)
            return $value;
    }
}

function find_states($capital_name){

    global $states, $capitals;

    $target_key = "";
    foreach($capitals as $key=>$value){
        if ($capital_name == $value)
            $target_key = $key;
    }

    $target_state = "";
    foreach($states as $key=>$value){
        if ($target_key == $value)
            $target_state = $key;
    }

    return $target_state;
}

function check_state_or_capital($name){

    global $states, $capitals;

    if (array_key_exists($name, $states))
        return "state";
    foreach ($capitals as $key=>$value){
        if ($name == $value)
            return "capital";
    }
    return "unknown";
}


function search_by_states($string){

    

    $names = explode(",", $string);
    $trimmed_names = [];
    foreach($names as $name){
        $name = trim($name);
        array_push($trimmed_names, $name);
    }   
    
    $results = [];
    foreach($trimmed_names as $name){
        if (check_state_or_capital($name) == "state"){
            $capital_city = find_capital($name);
            if ($capital_city == NULL)
                array_push($results, "$name is neither a capital nor a state.");
            else
                array_push($results, "$capital_city is the capital of $name");
        }elseif(check_state_or_capital($name) == "capital"){
            $target_state = find_states($name);
            if ($target_state == "")
                array_push($results, "$name is neither a capital nor a state.");
            else
                array_push($results, "$name is the capital of $target_state");
        }else{
            array_push($results, "$name is neither a capital nor a state.");
        }
    }

    return $results;

}



?>