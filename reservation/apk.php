<?php
require_once('../includes/config.php'); // To connect to database
require_once('../vendor/autoload.php'); // To load license plate validation
require('../includes/validation-reservervation.php'); // To validate form

$currentDate = date('Y-m-d', strtotime("+1 day")); // Var for the current date + 1 day
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
            <img id="header" src="../images/header.png"
            alt="Garage nieuw rijswijk">
        </header>

        <main>
            <a href="../index.php">
                <button>Terug</button>
            </a>

            <div>
                <h1>Reservering voor APK keuring</h1>
                <h3>Vul hieronder uw gegevens in, de gegevens met * zijn verplicht.</h3>
            </div>

            <form action="" method="post">
                <!-- Inputs for user data that is needed for reservation -->
                <!-- Input for name, required -->
                <div>
                    <label for="naam">Naam*: </label>
                    <input type="text" id="naam" name="name"
                           value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
                    <p class="error-message"><?=$nameErr?></p>
                </div>

                <!-- Input for phone number -->
                <div>
                    <label for="telefoonnummer">Telefoonnummer: </label>
                    <input type="text" id="telefoonnummer" name="phone-number"
                           value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>">
                    <p class="error-message"><?=$phoneErr;?></p>
                </div>

                    <!-- Input for email address, required -->
                <div>
                    <label for="email-adres">Email*: </label>
                    <input type="text" id="email-adres" name="email-address"
                           value="<?=htmlspecialchars($email, ENT_QUOTES);?>">
                    <p class="error-message"><?=$emailErr;?></p>
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
                    <p><?=$pickedDate?></p>
                    <p class="error-message"><?=$pickedDateErr;?></p>
                </div>

                    <!-- Input for choosing a time, required -->
                <div>
                    <label for="tijd">Tijd*: </label>
                    <input type="time" id="tijd" name="picked-time" min="10:00" max="17:00" step="900"
                           value="<?=$pickedTime;?>">
                    <p class="error-message"><?=$pickedTimeErr;?></p>
                </div>

                <div>
                    <input type="hidden" name="type-reservation" value="APK">
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