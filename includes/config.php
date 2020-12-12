<?php
    // general settings
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "reservation_garage";

    $db = mysqli_connect($host, $user, $password, $database)
        or die("Error: " . mysqli_connect_error()); // if it dies give the error
?>
