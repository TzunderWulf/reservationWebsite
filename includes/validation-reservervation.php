<?php
require 'config.php'; // to connect to database (database settings)

$name = $phoneNumber = $email = $licensePlate = $description = $pickedDate = $pickedTime = $typeReservation = "";
$errors = [];

if ( isset($_POST['submit']) ) {
    $validForm = true;
    // checks if name isn't empty and if there are no numbers in the field
    if (empty($_POST['name'])) {
        $validForm = false;
        $errors['name'] = "Gelieve dit veld in te vullen.";
    } elseif (preg_match("/([0-9])/i", $_POST['name'])) {
        $errors['name'] = "Cijfers zijn niet toegestaan in dit veld.";
    } else {
        $name = htmlspecialchars($_POST['name']); // name is valid
    }

    if ($_POST['phone-number']) {
        // check if phone-number is formed correctly
        if (!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/",
            $_POST['phone-number'])) {
            $errors['phone-number'] = "Dit veld is verkeerd ingevuld.";
        } else {
            $phoneNumber = htmlspecialchars($_POST['phone-number']); // phone number is valid
        }
    }

    // check if email isn't empty and formed correctly
    if (empty($_POST['email-address'])) {
        $errors['email'] = "Gelieve dit veld in te vullen.";
    } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Dit veld is verkeerd ingevuld.";
    } else {
        $email = htmlspecialchars($_POST['email-address']); // email address is valid
    }

    // first make sure the field is in the form
    if (isset($_POST['license-plate'])) {
        // // then check if empty and if the form is valid
        $licenseplate = new \Intrepidity\LicensePlate\DutchLicensePlate($_POST['license-plate']);
        if (empty($_POST['license-plate'])) {
            $errors['license-plate'] = "Gelieve dit veld in te vullen.";
        } elseif ($licenseplate->isValid()) {
            $licensePlate = htmlspecialchars(strtoupper($_POST['license-plate'])); // license plate is valid
        } else {
            $errors['license-plate'] = "Dit veld is verkeerd ingevuld.";
        }
    }

    // first make sure the field is in the form
    if (isset($_POST['description'])) {
        // then check if empty
        if (empty($_POST['description'])) {
            $errors['description'] = "Gelieve dit veld in te vullen.";
        } else {
            $description = htmlspecialchars($_POST['description']); // description valid
        }
    }

    // checks if empty and if it isn't date <= today
    if (empty($_POST['picked-date'])) {
        $errors['picked-date'] = "Gelieve dit veld in te vullen.";
    } elseif ($_POST['picked-date'] <= date('Y-m-d')) {
        $errors['picked-date'] = "Gelieve een datum te kiezen na " . date('d-m-Y');
    } else {
        $pickedDate = htmlspecialchars($_POST['picked-date']); // date is valid
    }

    // checks if empty and if it time isn't before 08:00 or after 18:00
    if (empty($_POST['picked-time'])) {
        $errors['picked-time'] = "Gelieve dit veld in te vullen.";
    } elseif (date('G', strtotime($_POST['picked-time'])) < 8 || date('G', strtotime($_POST['picked-time'])) >= 18) {
        $errors['picked-time'] = "Gelieve een tijd te kiezen tussen 08:00 en 18:00.";
    } else {
        $pickedTime = htmlspecialchars($_POST['picked-time']); // time is valid
    }
    $typeReservation = $_POST['type-reservation']; // put the type of reservation in a variable

    if (empty($errors)) {
        require_once('send-mail.php'); // send a confirmation mail

        $query = sprintf("INSERT INTO customers (name, phonenumber, email, license_plate)
                             VALUES ('%s', '%s', '%s', '%s')",
            mysqli_escape_string($db, $name),
            mysqli_escape_string($db, $phoneNumber),
            mysqli_escape_string($db, $email),
            mysqli_escape_string($db, $licensePlate));
        $result = mysqli_query($db, $query);

        // insert reservation data into reservation database
        $query = sprintf("INSERT INTO reservations (customerid, type_reservation, date, time)
                             VALUES (LAST_INSERT_ID(), '%s', '%s', '%s')",
            mysqli_escape_string($db, $typeReservation),
            mysqli_escape_string($db, $pickedDate),
            mysqli_escape_string($db, $pickedTime));
        $result = mysqli_query($db, $query);
        mysqli_close($db);
        header('Location: ../confirmation.php');
    }
}