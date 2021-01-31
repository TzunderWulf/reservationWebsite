<?php

require 'config.php'; // to connect to database (database settings)

$name = $phoneNumber = $email = $licensePlate = $description = $pickedDate = $pickedTime = $typeReservation = "";
$errors = [];

if ( isset($_POST['submit']) ) {
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
        /* 
           set variable for pattern of Dutch phone number (every valid option of forming a mobile and landine phone
           number)
           then check if phone-number is formed correctly
        */
        $phonePattern = "/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/";
        if (!preg_match($phonePattern, $_POST['phone-number'])) {
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

    if (!$_POST['type-reservation'] || empty($_POST['type-reservation'])) {
        $errors['type-reservation'] = "Het lijkt erop dat er iets is misgegaan.";
    } else {
        $typeReservation = htmlspecialchars($_POST['type-reservation']); // put the type of reservation in a variable
    }

    if (empty($errors)) {
        require_once 'send-mail.php'; // send a confirmation mail

        // set variables to insert to database
        $name               = mysqli_escape_string($db, $name);
        $phoneNumber        = mysqli_escape_string($db, $phoneNumber);
        $email              = mysqli_escape_string($db, $email);
        $licensePlate       = mysqli_escape_string($db, $licensePlate);
        $description        = mysqli_escape_string($db, $description);
        $pickedDate         = mysqli_escape_string($db, $pickedDate);
        $pickedTime         = mysqli_escape_string($db, $pickedTime);
        $typeReservation    = mysqli_escape_string($db, $typeReservation);

        // add customer data into the database
        $query = "INSERT INTO customers (name, phonenumber, email, license_plate)
                  VALUES ('$name', '$phoneNumber', '$email', '$licensePlate')";
        $result = mysqli_query($db, $query);

        // add rerservation data into the database
        $query = "INSERT INTO reservations (customerid, type_reservation, date, time, description)
                  VALUES (LAST_INSERT_ID(), '$typeReservation', '$pickedDate', '$pickedTime', '$description')";
        $result = mysqli_query($db, $query);
        mysqli_close($db); // close connection

        header('Location: ../confirmation.php'); // send user to confirmation screen
    }
}