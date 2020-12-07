<?php
    // require_once('../includes/connect.php'); // to connect to database

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
            $dateErr= 'Dit veld is verplicht.'; // S: was $kenteken, moest $kentekenErr
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
            <link rel="stylesheet" href="../stylesheet.css">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
        <!-- R: Button bij gedaan bij de terug knop--->
            <a href="../index.php"><button2>Terug</button2></a>
            <h1>Afspraak maken voor auto onderhoud?</h1>
            <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

            <form action="" method="post">
                <!-- input voor naam !-->
                <div>
                <label for="name">Naam*: </label>
                <input type="text" id="name" name="name" value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
                <p class="error"><?=$nameErr;?></p><br>
                </div>
                <!-- input voor telefoon nummer !-->
                <label for="phoneNumber">Telefoonnummer: </label>
                <input type="text" id="phoneNumber" name="phoneNumber" maxlength="11" placeholder="06-12345678"
                value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>"><br>

                <!-- input voor email address !-->
                <div>
                <label for="email">Emailadres*: </label>
                <input type="text" id="email" name="email" placeholder="example@example.nl" value="<?=
                htmlspecialchars($email, ENT_QUOTES);?>">
                <p class="error"><?=$emailErr;?></p><br>
                </div>

                <!-- input voor kenteken !-->
                <div>
                <label for="licensePlate">Kenteken*: </label>
                <input type="text" id="licensePlate" name="licensePlate" maxlength="8" placeholder="AB-C3D-5" value="<?=
                htmlspecialchars($licensePlate, ENT_QUOTES);?>">
                <p class="error"><?=$licensePlateErr;?></p><br>
                </div>

                <!-- input voor omschrijving reparatie of herstel !-->
                <div>
                 <label for = "descRepairation">Omschrijving wat er gerepareerd of hersteld moet worden*: </label><br>
                 <textarea id="descRepairation" name="descRepair" rows="4" cols="50"></textarea>
                 <p class="error"><?=$descRepairErr;?></p><br>
                </div>

                <!-- input datum !-->
                <!-- R: Testen van Datum functie !-->
                <div>
                    <label for = "start">Kies hieronder een datum voor de resevering: </label><br>
                    <input type="date" id="start" name="tripStart" value="<?=
                    htmlspecialchars($date, ENT_QUOTES);?>">
                    <p class="error"><?=$dateErr;?></p><br>
                </div>

                <!-- Reset knop van Sara-->
                <!-- Form validatie fout? Wordt gegeven-->
                <input type="reset" name="reset" value="Reset">
                <input type="submit" name="submit" value="Bevestigen">
            </form>
        </body>
    </html