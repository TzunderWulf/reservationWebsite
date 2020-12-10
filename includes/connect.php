<?php
    // general settings
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "reservervation_db";

    $db = mysqli_connect($host, $user, $password, $database)
        or die("Error: " . mysqli_connect_error()); // if it dies give the error
?>
