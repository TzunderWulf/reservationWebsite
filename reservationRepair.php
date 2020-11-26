<?php

?>

<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Afspraak maken</title>
    </head>
    <body>
        <h1>Afspraak maken</h1>

        <form action="confirmation.php" method="post">
            <label for="voornaam">Voornaam:</label><br>
            <input type="text" id="voornaam" name="voornaam" value=""><br>

            <label for="achternaam">Achternaam:</label><br>
            <input type="text" id="achternaam" name="Achternaam" value=""><br>

            <label for="kenteken">Kenteken:</label><br>
            <input type="text" id="kenteken" name="Kenteken" value=""><br>

            <label for="telefoonnummer">Telefoonnummer:</label><br>
            <input type="text" id="telefoonnummer" name="Telefoonnummer" value=""><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="Email" value=""><br>

            <label for="werkzaamheden">Werkzaamheden: </label>
            <input type="text" id="werkzaamheden" name="werkzaamheden">

            <input type="submit" value="Verzend">
        </form>

    </body>
</html>