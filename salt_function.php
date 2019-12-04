<?php


function CreateSalt($length){
        $characterString = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890";
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString = $characterString[rand(0, strlen($characterString))];
        }
        return $randomString;
}