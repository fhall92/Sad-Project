<?php

function Sanitise($string='') {
	$string = str_replace('<', '\<', $string);
    $string = str_replace('>', '\>', $string);
    $string = str_replace("'", "\'",$string);
    $string = str_replace('"', '\"', $string);
    $string = str_replace('/', '\/', $string);
    $string = str_replace('\\', '/', $string);
    $string = str_replace('.', '\.', $string);
    $string = str_replace('(', '\(', $string);
    $string = str_replace(')', '\)', $string);
    $string = str_replace('{', '\{', $string);
    $string = str_replace('}', '\}', $string);
    $string = str_replace(';', '\;', $string);
    $string = str_replace('=', '\=', $string);

    

    return  $string;
}
?>