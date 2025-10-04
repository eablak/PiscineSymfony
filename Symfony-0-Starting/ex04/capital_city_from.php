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


function capital_city_from($city_name){
    
    global $states;
    global $capitals;

    if (array_key_exists($city_name, $states)){
        $abbreviation = $states[$city_name];
        foreach($capitals as $key=>$value){
            if ($abbreviation == $key){
                return $value . "\n";
            }
        }
    }else{
        return "Unknown\n";
    }

}


?>