<?php

?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Inloggen</title>
            <link rel="stylesheet" href="../styles/stylesheet_employee.css">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
            <h1>Welkom, log hieronder in.</h1>
            <form action="index_employee.php" method="post">
                <div>
                <label for="gebruikersnaam">Gebruikersnaam: </label>
                <input type="text" id="gebruikersnaam" name="username">
                <p class="error"></p>
                </div>

                <div>
                <label for="wachtwoord">Wachtwoord: </label>
                <input type="password" id="wachtwoord" name="password">
                <p class="error"></p>
                </div>

                <div>
                <input type="submit" name="submit" value="Inloggen">
                </div>
            </form>
        </body>
    </html>