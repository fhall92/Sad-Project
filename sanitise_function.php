<?php

function Sanitise($string='') {
	$string = str_replace('<', 	"&#x3c;", $string);
    $string = str_replace('>', '&#x3e;', $string);
    $string = str_replace("'", "&#x27;",$string);
    $string = str_replace('"', '&#x22;', $string);
    $string = str_replace('/', '&#x2f;', $string);
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