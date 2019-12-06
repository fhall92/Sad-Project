<?php

function Sanitise($string='') {
	$string = str_replace('<', 	"&#x3c;", $string);
    $string = str_replace('>', '&#x3e;', $string);
    $string = str_replace("'", "&#x27;",$string);
    $string = str_replace('"', '&#x22;', $string);
    $string = str_replace('/', '&#47;', $string);
    $string = str_replace('\\', '&#47;', $string);
    $string = str_replace('(', '&#40;', $string);
    $string = str_replace(')', '&#41;', $string);
    $string = str_replace('{', '&#123;', $string);
    $string = str_replace('}', '&#125;', $string);
    $string = str_replace('=', '&#61;', $string);

    return  $string;
}
?>