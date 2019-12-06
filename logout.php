<?php

require "header.php";

if (isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header("Location: home.php?logout=success");
    exit();
} else {
    header("Location: home.php?error=NotCurrentlyLoggedIn");
    exit();
}
