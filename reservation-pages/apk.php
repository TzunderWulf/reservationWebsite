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
        <link rel="stylesheet" href="../css/stylesheet.css">

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
            <a href="../index.php" class="button2">
                <button>Terug</button>
            </a>

            <div>
                <h1>Reservering voor APK keuring</h1>
                <h3>Vul hieronder uw gegevens in, de gegevens met * zijn verplicht.</h3>
                <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p>
            </div>

            <form action="" method="post">
                <!-- Inputs for user data that is needed for reservation -->
                <!-- Input for name, required -->
                <div>
                    <label for="name">Naam (voor- en achternaam)*: </label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
                    <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p>
                </div>

                <!-- Input for phone number -->
                <div>
                    <label for="phone-number">Telefoonnummer: </label>
                    <input type="text" id="phone-number" name="phone-number"
                           value="<?= htmlspecialchars($phoneNumber) ?>">
                    <p class="error-message"><?= isset($errors['phone-number']) ? $errors['phone-number'] : "" ?></p>
                </div>

                    <!-- Input for email address, required -->
                <div>
                    <label for="email-address">Email*: </label>
                    <input type="text" id="email-address" name="email-address"
                           value="<?= htmlspecialchars($email) ?>">
                    <p class="error-message"><?= isset($errors['email']) ? $errors['email'] : "" ?></p>
                </div>

                    <!-- Input for license plate, required -->
                <div>
                    <label for="license-plate">Kenteken*: </label>
                    <input type="text" id="license-plate" name="license-plate"
                           maxlength="8" value="<?= htmlspecialchars($licensePlate) ?>">
                    <p class="error-message"><?= isset($errors['license-plate']) ? $errors['license-plate'] : "" ?></p>
                </div>

                    <!-- Inputs for choosing a date and time for the reservation -->
                    <!-- Input for choosing a date, required -->
                <div>
                    <label for="picked-date">Datum*: </label>
                    <input type="date" id="picked-date" name="picked-date" min="<?= $currentDate ?>"
                           value="<?= htmlspecialchars($pickedDate) ?>">
                    <p class="error-message"><?= isset($errors['picked-date']) ? $errors['picked-date'] : "" ?></p>
                </div>

                    <!-- Input for choosing a time, required -->
                <div>
                    <label for="picked-time">Tijd (Tussen 8:00 - 18:00)*: </label>
                    <input type="time" id="picked-time" name="picked-time" min="08:00" max="18:00" step="1800"
                           value="<?= htmlspecialchars($pickedTime) ?>">
                    <p class="error-message"><?= isset($errors['picked-time']) ? $errors['picked-time'] : "" ?></p>
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