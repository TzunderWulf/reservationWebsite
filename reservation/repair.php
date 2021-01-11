<?php
    require_once('../includes/config.php'); // To connect to database
    require_once('../vendor/autoload.php');
    // variables for inputs
    $name = '';
    $phoneNumber = '';
    $email = '';
    $licensePlate= '';
    $descRepair = '';
    $date='';

    // error variables
    $nameErr = '';
    $emailErr = '';
    $licensePlateErr = '';
    $descRepairErr  = '';
    $dateErr = '';

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
            $email = htmlspecialchars($_POST['email']);
        }

        // validation for the license plate input
        if (!isset($_POST['licensePlate']) || $_POST['licensePlate'] === '') {
            $validForm = false;
            $licensePlateErr = 'Dit veld is verplicht.'; // S: was $kenteken, moest $kentekenErr
        } else {
            $licensePlate = htmlspecialchars($_POST['licensePlate']);
        }

        // validation for description input
        if (!isset($_POST['descRepair']) || $_POST['descRepair'] === '') {
            $validForm = false;
            $descRepairErr = 'Dit veld is verplicht.';
        } else {
            $descRepair = htmlspecialchars($_POST['descRepair']);
        }
        if (!isset($_POST['date']) || $_POST['date'] === '') {
            $validForm = false;
            $dateErr= 'Dit veld is verplicht.'; // Date error
        } else {
            $date = htmlspecialchars($_POST['licensePlate']);
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
            <a href="../index.php">Terug</a>
            <h1>Afspraak maken voor auto onderhoud?</h1>
            <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

            <form action="" method="post">
                <!-- input voor naam !-->
                <div>
                    <label for="name">Naam*: </label>
                    <input type="text" id="name" name="name"
                           value="<?= htmlspecialchars($_POST['name'], ENT_QUOTES) ?>">
                    <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p><br>
                </div>
                <!-- input voor telefoon nummer !-->
                <div>
                    <label for="phone-number">Telefoonnummer: </label>
                    <input type="text" id="phone-number" name="phone-number" maxlength="11" placeholder="06-12345678"
                           value="<?= htmlspecialchars($_POST['phone-number'], ENT_QUOTES) ?>">
                    <p class="error-message"><?= isset($errors['phone-number']) ? $errors['phone-number'] : "" ?></p>
                </div>
                <!-- input voor email address !-->
                <div>
                    <label for="email-address">Emailadres*: </label>
                    <input type="text" id="email-address" name="email-address" placeholder="example@example.nl"
                           value="<?= htmlspecialchars($_POST['email-address'], ENT_QUOTES) ?>">
                    <p class="error-message"><?= isset($errors['email']) ? $errors['email'] : "" ?></p>
                </div>

                <!-- input voor kenteken !-->
                <div>
                    <label for="license-plate">Kenteken*: </label>
                    <input type="text" id="license-plate" name="license-plate" maxlength="8" placeholder="AB-C3D-5"
                           value="<?= htmlspecialchars($_POST['license-plate'], ENT_QUOTES) ?>">
                    <p class="error-message"><?= isset($errors['license-plate']) ? $errors['license-plate'] : "" ?></p>
                </div>

                <!-- input voor omschrijving reparatie of herstel !-->
                <div>
                    <label for = "description">Omschrijving wat er gerepareerd of hersteld moet worden*: </label>
                    <textarea id="description" name="description" rows="4" cols="50"></textarea>
                    <p class="error-message"><?= isset($errors['description']) ? $errors['description'] : "" ?></p>
                </div>

                <!-- input datum !-->
                <!-- R: Testen van Datum functie !-->
                <div>
                    <label for="picked-date">Kies hieronder een datum voor de resevering: </label>
                    <input type="date" id="picked-date" name="picked-date" value="<?= htmlspecialchars($date, ENT_QUOTES) ?>">
                    <p class="error-message"><?= isset($errors['picked-date']) ? $errors['picked- date'] : "" ?></p>
                </div>

                <!-- Reset knop van Sara-->
                <input type="reset" name="reset" value="Reset">
                <input type="submit" name="submit" value="Bevestigen">
            </form>
        </body>
    </html