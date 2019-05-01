<?php

function validColor($color){
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validString($string){
    return (($string != "") && ctype_alpha($string));
}

function validNum($num){
    return ctype_digit($num) && $num > 0 && !empty($num);
}

function validHabitat($habitat) {
    global $f3;

    // if there's no habitat
    if(empty($habitat)) {
        return false;
    }

    foreach($habitat as $habit) {
        if(!in_array($habit, $f3->get('habitats'))) {
            return false;
        }
    }

    return true;
}