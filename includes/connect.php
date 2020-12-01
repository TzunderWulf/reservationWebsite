<?php
    // general settings
    $host = "";
    $user = "";
    $password = "";
    $database = "";

    $db = mysqli_connect($host, $user, $password, $database)
        or die("Error: " . mysqli_connect_error()); // if it dies give the error
?>
