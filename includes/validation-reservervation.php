<?php
// variables for inputs
$name = $phoneNumber = $email = $licensePlate = $description = $pickedCar = $pickedDate = $pickedTime = $typeReservation = '';
$errors = [];
$currentDate = date('Y-m-d'); // var for the current date

// PHP validation of forms
if (isset($_POST['submit'])) {
    // validation for the name input, checks if it is empty and if theres numbers in the name
    if (!$_POST['name']) {
        $errors['name'] = "Dit veld is verplicht.";
    } elseif (preg_match("/([0-9])/i", $_POST['name'])) {
        $errors['name'] = "Veld verkeerd ingevuld.";
    } else {
        $name = trim(htmlspecialchars($_POST['name']));
    }

    // * if phone number is given, then validate that as well
    if ($_POST['phone-number']) {
        if (!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/", $_POST['phone-number'])) {
            $errors['phone-number'] = "Veld verkeerd ingevuld.";
        } else {
            $phoneNumber = trim(htmlspecialchars($_POST['phone-number']));
        }
    }

    // validation for the email input, checks if it is empty and if it is a valid email
    if (!$_POST['email-address']) {
        $errors['email'] = "Dit veld is verplicht.";
    } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veld verkeerd ingevuld.";
    } else {
        $email = trim(htmlspecialchars($_POST['email-address']));
    }

    // * checks if license plate is even in the form
    if (isset($_POST['license-plate'])) {
        // validation for the license plate input, checks if it is empty and if it is a valid license plate
        $licenseplate = new \Intrepidity\LicensePlate\DutchLicensePlate($_POST['license-plate']);
        if (!($_POST['license-plate'])) {
            $errors['license-plate'] = "Dit veld is verplicht.";
        } elseif ($licenseplate->isValid()) {
            $licensePlate = trim(htmlspecialchars($_POST['license-plate']));
        } else {
            $errors['license-plate'] = "Veld verkeerd ingevuld.";
        }
    }

    // * checks if description is even in the form
    if (isset($_POST['description'])) {
        // validation for the description input, checks if it is empty
        if (!$_POST['description']) {
            $errors['description'] = "Dit veld is verplicht.";
        } else {
            $description = trim(htmlspecialchars(trim($_POST['description'])));
        }
    }

    if (isset($_POST['picked-car'])) {
        // validation for the car choice input, checks if it is empty
        if (!$_POST['picked-car']) {
            $errors['picked-car'] = "Dit veld is verplicht.";
        } else {
            $pickedCar = $_POST['picked-car'];
        }
    }
    // validation for date
    if (!$_POST['picked-date']) {
        $errors['picked-date'] = "Dit veld is verplicht.";
    } elseif ($_POST['picked-date'] <= $currentDate) {
        $errors['picked-date'] = "U kunt deze datum niet kiezen";
    } else {
        $pickedDate = htmlspecialchars($_POST['picked-date']);
    }

    // validation for time
    if (empty($_POST['picked-time'])) {
        $errors['picked-time'] = "Dit veld is verplicht.";
    } elseif (date('G', strtotime($_POST['picked-time'])) < 8 || date('G', strtotime($_POST['picked-time'])) >= 18) {
        $errors['picked-time'] = "U kunt deze tijd niet kiezen.";
    } else {
        $pickedTime = htmlspecialchars($_POST['picked-time']);
    }

    $typeReservation = $_POST['type-reservation'];
    // if the entire form is valid:
    if (!$errors) {
        require('send-mail.php');
        $customerQuery = sprintf("INSERT INTO customers (name, phonenumber, email, license_plate) 
                                  VALUES ('%s', '%s', '%s', '%s')",
            mysqli_escape_string($name),
            mysqli_escape_string($phoneNumber),
            mysqli_escape_string($email),
            mysqli_escape_string($licensePlate));
        $customerResult = mysqli_query($db, $customerQuery);

        $reservationQuery = sprintf("INSERT INTO reservations (customerid, type_reservation, date, time) 
                                     VALUES (LAST_INSERT_ID(),  '%s', '%s', '%s')",
            mysqli_escape_string($typeReservation),
            mysqli_escape_string($pickedDate),
            mysqli_escape_string($pickedTime));
        $reservationResult = mysqli_query($db, $reservationQuery);
        }
        mysqli_close($db);
    }
