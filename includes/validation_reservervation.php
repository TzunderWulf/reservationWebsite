<?php
// variables for inputs and error messages
$name = $phoneNumber = $email = $licensePlate = $description = $pickedCar = $pickedDate = $pickedTime = $typeReservation = '';
$nameErr = $phoneErr = $emailErr = $licensePlateErr = $descriptionErr = $pickedCarErr = $pickedDateErr = $pickedTimeErr = '';
var_dump($_POST);
$currentDate = date('Y-m-d'); // Var for the current date + 1 day

// PHP validation of forms
if (isset($_POST['submit'])) {
    $validForm = true; // boolean to check if form is valid, can change per field input

    // validation for the name input, checks if it is empty and if theres numbers in the name
    if (empty($_POST['name'])) {
        $validForm = false;
        $nameErr = "Dit veld is verplicht.";
    } elseif (preg_match("/([0-9])/i", $_POST['name'])) {
        $validForm = false;
        $nameErr = "Veld verkeerd ingevuld.";
    } else {
        $name = trim(htmlspecialchars($_POST['name']));
    }

    // * if phone number is given, then validate that as well
    if (!empty($_POST['phone-number'])) {
        if (!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/", $_POST['phone-number'])) {
            $validForm = false;
            $phoneErr = "Veld verkeerd ingevuld.";
        } else {
            $phoneNumber = trim(htmlspecialchars($_POST['phone-number']));
        }
    }

    // validation for the email input, checks if it is empty and if it is a valid email
    if (empty($_POST['email-address'])) {
        $validForm = false;
        $emailErr = "Dit veld is verplicht.";
    } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
        $validForm = false;
        $emailErr = "Veld verkeerd ingevuld.";
    } else {
        $email = trim(htmlspecialchars($_POST['email-address']));
    }

    // * checks if license plate is even in the form
    if (isset($_POST['license-plate'])) {
        // validation for the license plate input, checks if it is empty and if it is a valid license plate
        $licenseplate = new \Intrepidity\LicensePlate\DutchLicensePlate($_POST['license-plate']);
        if (empty($_POST['license-plate'])) {
            $validForm = false;
            $licensePlateErr = "Dit veld is verplicht.";
        } elseif ($licenseplate->isValid()) {
            $licensePlate = trim(htmlspecialchars($_POST['license-plate']));
        } else {
            $validForm = false;
            $licensePlateErr = "Veld verkeerd ingevuld.";
        }
    }

    // * checks if description is even in the form
    if (isset($_POST['description'])) {
        // validation for the description input, checks if it is empty
        if (empty($_POST['description'])) {
            $validForm = false;
            $descriptionError = "Dit veld is verplicht.";
        } else {
            $description = trim(htmlspecialchars(trim($_POST['description'])));
        }
    }

    if (isset($_POST['picked-car'])) {
        // validation for the car choice input, checks if it is empty
        if (empty($_POST['picked-car'])) {
            $validForm = false;
            $pickedCarErr = "Dit veld is verplicht.";
        } else {
            $pickedCar = $_POST['picked-car'];
        }
    }

    $typeReservation = $_POST['type-reservation'];

    // validation for date
    if (empty($_POST['picked-date'])) {
        $validForm = false;
        $pickedDateErr = "Dit veld is verplicht.";
    } elseif ($_POST['picked-date'] <= $currentDate) {
        $validForm = false;
        $pickedDateErr = "U kunt deze datum niet kiezen";
    } else {
        $pickedDate = htmlspecialchars($_POST['picked-date']);
    }

    // validation for time
    if (empty($_POST['picked-time'])) {
        $validForm = false;
        $pickedTimeErr = "Dit veld is verplicht.";
    } else {
        $pickedTime = htmlspecialchars($_POST['picked-time']);
    }

    // if the entire form is valid:
    if ($validForm) {
        header('Location: ../confirmation.php');
        $customerQuery = sprintf("INSERT INTO customers (name, phonenumber, email, license_plate) 
                                  VALUES ('%s', '%s', '%s', '%s')",
            $db ->real_escape_string($name),
            $db->real_escape_string($phoneNumber),
            $db->real_escape_string($email),
            $db->real_escape_string($licensePlate));
        $customerResult = mysqli_query($db, $customerQuery);

        $reservationQuery = sprintf("INSERT INTO reservations (customerid, type_reservation, date, time) 
                                     VALUES (LAST_INSERT_ID(),  '%s', '%s', '%s')",
            $db->real_escape_string($typeReservation),
            $db ->real_escape_string($pickedDate),
            $db->real_escape_string($pickedTime));
        $reservationResult = mysqli_query($db, $reservationQuery);
        }
        mysqli_close($db);
    }
