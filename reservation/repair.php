<?php
require_once('../includes/config.php'); // To connect to database
require_once('../vendor/autoload.php'); // To load license plate validation
require('../includes/validation-reservervation.php'); // To validate form

$currentDate = date('Y-m-d', strtotime("+1 day")); // Var for the current date + 1 day
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
            <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p>

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
                    <label for="picked-date">Datum*: </label>
                    <input type="date" id="picked-date" name="picked-date" min="<?= $currentDate ?>"
                           value="<?= htmlspecialchars($_POST['picked-date']) ?>">
                    <p class="error-message"><?= isset($errors['picked-date']) ? $errors['picked-date'] : "" ?></p>
                </div>

                <div>
                    <label for="picked-time">Tijd*: </label>
                    <input type="time" id="picked-time" name="picked-time" min="08:00" max="18:00" step="1800"
                           value="<?= htmlspecialchars($_POST['picked-time']) ?>">
                    <p class="error-message"><?= isset($errors['picked-time']) ? $errors['picked-time'] : "" ?></p>
                </div>

                <input type="hidden" name="type-reservation" value="repair">

                <!-- Reset knop van Sara-->
                <input type="reset" name="reset" value="Reset">
                <input type="submit" name="submit" value="Bevestigen">
            </form>
        </body>
    </html