<?php

require "header.php";

if(isset($_SESSION['id'])){
    session_unset();
    session_destroy();
    header("Location: ../sadproject/home.php?logout=success");
    exit();

}

else{
    header("Location: ../sadproject/home.php?error=NotCurrentlyLoggedIn");
    exit();
}

?>