<?php
    require_once('../includes/connect.php'); // To connect to database

    // Variables for type reservation to send to database
    $typeReservation = "APK";

    // Variables for inputs and errors
    $name = $phoneNumber = $emailAddress = $licensePlate = $pickedDate = $pickedTime = '';
    $nameErr = $emailAddressErr = $licensePlateErr = $dateErr = $timeErr = $databaseErr= '';

    // Variable for the current date + 1
    $currentDate = date('Y-m-d', strtotime("+1 day"));

    // PHP validation of the form
    if (isset($_POST['submit'])) {
        $validForm = true; // boolean to check if the form is valid, can change based per field input

        // validation for the name input, checks if it is empty and if theres numbers in the name
        if (empty($_POST['name'])) {
            $validForm = false;
            $nameErr = "Dit veld is verplicht.";
        } elseif (preg_match("/(\d)/", $_POST['name'])) {
            $validform = false;
            $nameErr = "Er zitten nummers in de opgegeven naam.";
        } else {
            $name = htmlspecialchars($_POST['name']);
        }

        // validation for the email input, checks if it is empty and if it is a valid email
        if (empty($_POST['email-address'])) {
            $validForm = false;
            $emailAddressErr = "Dit veld is verplicht.";
        } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
            $validForm = false;
            $emailErr = 'Geen geldige email ingevoerd.';
        } else {
            $emailAddress = htmlspecialchars($_POST['email-address']);
        }

        // validation for the license plate input, checks if it is empty
        // and *if it is a valid license plate*
        if (empty($_POST['license-plate'])) {
            $validForm = false;
            $licensePlateErr = 'Dit veld is verplicht.';
        } else {
            $licensePlate = htmlspecialchars($_POST['license-plate']);
        }
        // vaidation for date
        $pickedDate = htmlspecialchars($_POST['picked-date']);
        // vaidation for time
        $pickedTime = htmlspecialchars($_POST['picked-time']);

        $phoneNumber = htmlspecialchars($_POST['phone-number']);

        if ($validForm) {
            header('../confirmation.php');
/*
            $reservationQuery = sprintf("INSERT INTO reservations (type_reservation, date, time) VALUES ('%s', '%s', '%s')",
                $db ->real_escape_string($typeReservation),
                $db ->real_escape_string($pickedDate),
                $db->real_escape_string($pickedTime));

            $customerQuery = sprintf("INSERT INTO customers (name, phonenumber, email, license_plate) VALUES ('%s', '%s', '%s', '%s')",
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
        <title>Reserveren</title>
        <link rel="stylesheet" href="../styles/stylesheet.css">

        <!-- Google Font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    </head>


    <body>
        <header>
            <img id="header" src="https://garagenieuwrijswijk.nl/wp-content/uploads/2014/01/cropped-header45.png"
            alt="Garage nieuw rijswijk">
        </header>

        <main>
            <a href="../index.php">
                <button>Terug</button>
            </a>

            <h1>Reservering voor APK keuring</h1>
            <h3>Vul hieronder uw gegevens in, de gegevens met * zijn verplicht.</h3>

            <h3><?=$databaseErr;?></h3>

            <form action="" method="post">

                <!-- Inputs for user data that is needed for reservation -->
                <!-- Input for name, required -->
                <div>
                    <label for="naam">Naam*: </label>
                    <input type="text" id="naam" name="name"
                        value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
                    <p class="error-message"><?=$nameErr;?></p>
                </div>

                <!-- Input for phone number -->
                <div>
                    <label for="telefoonnummer">Telefoonnummer: </label>
                    <input type="text" id="telefoonnummer" name="phone-number"
                        maxlength="11" value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>">
                </div>

                <!-- Input for email address, required -->
                <div>
                    <label for="email-adres">Email*: </label>
                    <input type="text" id="email-adres" name="email-address"
                        value="<?=htmlspecialchars($emailAddress, ENT_QUOTES);?>">
                    <p class="error-message"><?=$emailAddressErr;?></p>
                </div>

                <!-- Input for license plate, required -->
                <div>
                    <label for="kenteken">Kenteken*: </label>
                    <input type="text" id="kenteken" name="license-plate"
                        maxlength="8" value="<?=htmlspecialchars($licensePlate, ENT_QUOTES);?>">
                    <p class="error-message"><?=$licensePlateErr;?></p>
                </div>

                <!-- Inputs for choosing a date and time for the reservation -->
                <!-- Input for choosing a date, required -->
                <div>
                    <label for="datum">Datum*: </label>
                    <input type="date" id="datum" name="picked-date" min="<?=$currentDate;?>" value="<?=$pickedDate;?>">
                </div>

                <!-- Input for choosing a time, required -->
                <div>
                    <label for="tijd">Tijd*: </label>
                    <input type="time" id="tijd" name="picked-time" min="10:00" max="17:00" step="900"
                           value="<?=$pickedTime;?>">
                </div>

                <div>
                    <input type="submit" name="submit" value="Bevestigen">
                </div>
            </form>
        </main>

        <!--
        <footer>
            <p>Made with the power of PHP</p>
        </footer>
        -->
    </body>
</html>