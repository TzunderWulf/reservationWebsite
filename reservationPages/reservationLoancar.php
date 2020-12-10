<?php
    require_once('../includes/connect.php'); // To connect to database

    // Variables for inputs and errors
    $name = $phoneNumber = $email = $carChoice = $pickedDate = $pickedTime = '';
    $nameErr = $emailErr = $carChoiceErr = $dateErr = $timeErr = $databaseErr= '';

    // Variable for the current date + 1
    // for picking date

    // PHP validation of the form
    if (isset($_POST['submit'])) {
        $validForm = true; // boolean to check if the form is valid, can change based per field input

        // validation for the name input, checks if it is empty and if theres numbers in the name
        if (empty($_POST['name'])) {
            $validForm = false;
            $nameErr = "Dit veld is verplicht.";
        } elseif (preg_match("/(\d)/i", $_POST['name'])) {
            $validform = false;
            $nameErr = "Veld verkeerd ingevoerd.";
        } else {
            $name = htmlspecialchars($_POST['name']);
        }

        // validation for the email input, checks if it is empty and if it is a valid email
        if (empty($_POST['email-address'])) {
            $validForm = false;
            $emailAddressErr = "Dit veld is verplicht.";
        } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
            $validForm = false;
            $emailErr = "Veld verkeerd ingevoerd.";
        } else {
            $emailAddress = htmlspecialchars($_POST['email-address']);
        }

        // validation for the car input
        if (!isset($_POST['car']) || $_POST['car'] === '') {
            $validForm = false;
            $carChoiceErr = 'Dit veld is verplicht.';
        } else {
            $carChoice = htmlspecialchars($_POST['car']);
        }
        $phoneNumber = $_POST['phone-number'];
        $pickedDate = htmlspecialchars($_POST['picked-date']);
        $pickedTime = htmlspecialchars($_POST['picked-time']);

        // if the entire form is valid sent user to confirmation page
        if ($validForm) {
            header('Location: ../confirmation.php');
/*
            $reservationQuery = sprintf("INSERT INTO users (Date, Time) VALUES ('%s', '%s')",
                $db ->real_escape_string($pickedDate),
                $db->real_escape_string($pickedTime));

            $customerQuery = sprintf("INSERT INTO users (Name, PhoneNumber, Email, LicensePlate) VALUES ('%s', '%s', '%s', '%s')",
                $db ->real_escape_string($name),
                $db->real_escape_string($phoneNumber),
                $db->real_escape_string($emailAddress),
                $db->real_escape_string($licensePlate));

            $reservationResult = mysqli_query($db, $reservationQuery);
            $customerResult = mysqli_query($db, $customerQuery);

            if (!$reservationResult || !$customerResult) {
                $databaseErr = "Resevering mislukt.";
            }
*/
        }
    }
?>


<!doctype html>
    <html lang="nl">
        <head>
            <title>Reserveren auto</title>
            <link rel="stylesheet" href="../styles/stylesheet.css">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
        <!-- R: Button bij gedaan bij de terug knop--->
            <a href="../index.php"><button2>Terug</button2></a>
            <h1>Afspraak maken voor het lenen van een auto</h1>
            <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

            <form action="" method="post">
                <!-- input for name !-->
                <label for="voornaam">Naam*: </label>
                <input type="text" id="voornaam" name="name"value="<?=
                htmlspecialchars($name, ENT_QUOTES);?>">
                <p class="error"><?=$nameErr;?></p><br>

                <!-- input for phone number !-->
                <label for="telefoonnummer">Telefoonnummer: </label>
                <input type="text" id="telefoonnummer" name="phoneNumber" maxlength="11" placeholder="06-12345678"
                value="<?=$phoneNumber?>"><br>

                <!-- input for email address !-->
                <label for="email">Emailadres*: </label>
                <input type="text" id="email" name="email" placeholder="example@example.nl"value="<?=
                htmlspecialchars($email, ENT_QUOTES);?>">
                <p class="error"><?=$emailErr;?></p><br>

                <!-- input for license plate !-->
                <label for="autoKeuze">Kies een van de twee auto's*: </label>
                <input type="radio" id="autoKeuze" name="carChoice" value="1"<?php
                if ($carChoice == '1') {
                    echo ' checked';
                }?>>Auto 1
                <input type="radio" id="autoKeuze" name="carChoice" value="2"<?php
                if ($carChoice == '2') {
                    echo ' checked';
                }?>>Auto 2
                <p class="error"><?=$carChoiceErr;?></p>

                <h3>Selecteer hieronder de periode dat u de auto wilt lenen.</h3>

                <!-- agenda with possible times !-->

                <!-- resetting and submitting the form to validate !-->
                <!-- in case the form fails to validate, user is send back here and error is shown !-->
                <input type="reset" name="reset" value="Reset">
                <input type="submit" name="submit" value="Bevestigen">
            </form>
        </body>
    </html>
