<?php
session_start();

require_once('../includes/config.php');

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$indexNumber = $_GET['index'];
?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Homescreen</title>
            <link rel="stylesheet" href="../styles/stylesheet_employee.css">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
            <h1><?php print_r($row['type_reservation']);?></h1>
            <ul>
                <!-- Name -->
                <li>Naam: <?php print_r($row['name']);?></li>

                <!-- Email -->
                <li>Email adres: <?php print_r($row['email']);?></li>

                <!-- phone number (if it is exists) -->
                <?php if (isset($row['phoneNumber'])) { ?>
                    <li>Telefoonnummer: <?php print_r($row['phoneNumber']);?></li>
                <?php } ?>

                <!-- license plate (if it is exists) -->
                <?php if (isset($row['licensePlate'])) { ?>
                    <li>Kenteken: <?php print_r(strtoupper($row['licensePlate']));?></li>
                <?php } ?>

                <!-- description (if it is exists) -->
                <?php if (isset($row['description'])) { ?>
                    <li>Omschrijving: <?php print_r($row['description']);?></li>
                <?php } ?>

                <!-- car choice (if it is exists) -->
                <?php if (isset($row['carChoice'])) { ?>
                    <li>Keuze auto: <?php print_r($row['carChoice']);?></li>
                <?php } ?>
            </ul>
            <a href="index_employee.php">Terug naar de startpagina</a>
        </body>
    </html>
