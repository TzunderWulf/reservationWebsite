<?php
    // variables for inputs
    $name = '';
    $phoneNumber = '';
    $email = '';
    $carChoice = '';

    // error variables
    $nameErr = '';
    $emailErr = '';
    $carChoiceErr = '';

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
        if (!isset($_POST['carChoice']) || $_POST['carChoice'] === '') {
            $validForm = false;
            $carChoiceErr = 'Dit veld is verplicht.';
        } else {
            $carChoice = htmlspecialchars($_POST['carChoice']);
        }
        $phoneNumber = $_POST['phoneNumber'];

        // if the entire form is valid sent user to confirmation page
        if ($validForm) {
            header('Location: ../confirmation.php');
        }
    }
?>


<!doctype html>
    <html lang="nl">
        <head>
            <title>Reserveren auto</title>
            <link rel="stylesheet" href="../stylesheet.css">
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
