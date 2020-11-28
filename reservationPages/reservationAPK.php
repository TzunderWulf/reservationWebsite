<?php

?>

<!doctype html>
<html lang="nl">
    <head>
        <title>Reserveren APK</title>
        <link rel="stylesheet" href="../stylesheet.css">
    </head>

    <body>
        <a href="../index.php">Terug</a>
        <h1>Afspraak maken voor APK keuring</h1>
        <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

        <form action="" method="post">
            <!-- input for name !-->
            <label for="voornaam">Naam*: </label>
            <input type="text" id="voornaam" name="voornaam"><br>

            <!-- input for phone number !-->
            <label for="telefoonnummer">Telefoonnummer: </label>
            <input type="text" id="telefoonnummer" name="telefoonnummer" maxlength="11" placeholder="06-12345678"><br>

            <!-- input for email address !-->
            <label for="email">Emailadres*: </label>
            <input type="email" id="email" name="email" placeholder="example@example.nl"><br>

            <!-- input for license plate !-->
            <label for="kenteken">Kenteken*: </label>
            <input type="text" id="kenteken" name="kenteken" maxlength="8" placeholder="AB-C3D-5"><br>
        </form>

        <h3>Kies hieronder een datum voor de resevering.</h3>

        <!-- agenda with possible times !-->

        <!-- resetting and submitting the form to validate !-->
        <!-- in case the form fails to validate, user is send back here and error is shown !-->
        <input type="reset" name="reset" value="Reset">
        <input type="submit" name="submit" value="Bevestigen">

    </body>
</html>
