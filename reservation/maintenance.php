<?php
    require_once('../includes/config.php'); // To connect to database
    require_once('../vendor/autoload.php');
    // variables for inputs
    $name = '';
    $phoneNumber = '';
    $email = '';
    $licensePlate= '';
    $descMaintenace = '';

    // error variables
    $nameErr = '';
    $emailErr = '';
    $licensePlateErr = '';
    $descMaintenaceErr = '';

    // php validation of form
    if (isset($_POST['submit'])) {
        $validForm = true; // boolean to check if form is valid, changes based on if field is empty

        // validation for the name input
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $validForm = false;
            $nameErr = 'Dit veld is verplicht.';
        } else {
            $name = htmlspecialchars($_POST['name']);
        }

        // validation for the email input
        if (!isset($_POST['email']) || $_POST['email'] === '') {
            $validForm = false;
            $emailErr = 'Dit veld is verplicht.';
        } else {
            $email = htmlspecialchars($_POST['email']);
            // validation for the valid email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validForm = false;
                $emailErr = 'Vekeerde email.';
            }
        }

        // validation for the license plate input
        if (!isset($_POST['licensePlate']) || $_POST['licensePlate'] === '') {
            $validForm = false;
            $licensePlateErr = 'Dit veld is verplicht.'; // S: was $kenteken, moest $kentekenErr
        } else {
            $licensePlate = htmlspecialchars($_POST['licensePlate']);
        }

        // validation for description input
        if (!isset($_POST['descMaintenace']) || $_POST['descMaintenace'] === '') {
            $validForm = false;
            $descMaintenaceErr= 'Dit veld is verplicht.';
        } else {
            $descMaintenace = htmlspecialchars($_POST['descMaintenace']);
        }
        $phoneNumber = $_POST['phoneNumber']; // phonenumber

        // if the entire form is valid sent user to confirmation page
        if ($validForm) {
            header('Location: ../confirmation.php');
        }
    }
?>


<!doctype html>
    <html lang="nl">
        <head>
            <title>Afspraak voor auto onderhoud</title>
            <link rel="stylesheet" href="../styles/stylesheet.css">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
            <header>
                <img id="header" src="../images/header.png" alt="Garage nieuw rijswijk">
            </header>
        <!-- R: Button bij gedaan bij de terug knop--->
            <a href="../index.php"><button2>Terug</button2></a>
            <h1>Afspraak maken voor auto onderhoud?</h1>
            <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

            <form action="" method="post">
                 <!-- input voor naam !-->
                <label for="name">Naam*: </label>
                <input type="text" id="name" name="name" value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
                <p class="error"><?= isset($errors['name']) ? $errors['phone-number'] : "" ?></p><br>

                <!-- input voor telefoon nummer !-->
                <label for="phoneNumber">Telefoonnummer: </label>
                <input type="text" id="phoneNumber" name="phoneNumber" maxlength="11" placeholder="06-12345678"
                value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>">
                <p class="error-message"><?= isset($errors['phone-number']) ? $errors['phone-number'] : "" ?></p><br>

                <!-- input voor email address !-->
                <label for="email">Emailadres*: </label>
                <input type="text" id="email" name="email-address" placeholder="example@example.nl" value="<?=
                htmlspecialchars($email, ENT_QUOTES);?>">
                <p class="error"><?= isset($errors['email']) ? $errors['email'] : "" ?></p><br>

                <!-- input voor kenteken !-->
                <label for="kenteken">Kenteken*: </label>
                <input type="text" id="kenteken" name="license-plate" maxlength="8" placeholder="AB-C3D-5" value="<?=
                htmlspecialchars($licensePlate, ENT_QUOTES); ?>">
                <p class="error"><?= isset($errors['license-plate']) ? $errors['license-plate'] : "" ?></p><br>

                <!-- input voor decription !-->
                <label for = "omschrijving-werkzaamheden" >Omschrijving wat voor type onderhoud*: </label><br>
                <textarea id="omschrijving-werkzaamheden" name="description" rows="4" cols="50"></textarea><br>
                <p class="error"><?= isset($errors['description']) ? $errors['description'] : "" ?></p><br>

                <h3>Kies hieronder een datum voor de resevering.</h3>

                <!-- agenda!-->

                <!-- Reset knop van Sara-->
                <!-- Form validatie. Fout? Wordt gegeven-->
                <input type="reset" name="reset" value="Reset">
                <input type="submit" name="submit" value="Bevestigen">
            </form>
        </body>
    </html