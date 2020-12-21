<?php
require_once("../includes/validation_login.php")
?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Inloggen</title>
            <link rel="stylesheet" href="../styles/stylesheet-login.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body class="container">
        <div class="item-a">
            <img src="https://garagenieuwrijswijk.nl/wp-content/uploads/2014/01/cropped-header45.png" alt="header image">
        </div>

        <div class="item-b">
            <form action="" method="post">
                <h1>Welkom, log hieronder in.</h1>

                <div class="form-field">
                <label for="gebruikersnaam">Gebruikersnaam:</label>
                <input type="text" id="gebruikersnaam" name="username" value="<?=$username?>">
                <p class="error-message"><?=$usernameErr?></p>
                </div>

                <!-- adding capslock detection? -->

                <div class="form-field">
                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" id="wachtwoord" name="password">
                <p class="error-message"><?=$passwordErr?></p>
                </div>

                <div>
                <input type="submit" name="submit" value="Inloggen">
                </div>
            </form>
        </div>

        <div class="item-c">
            <p>Aan dit systeem kunnen geen rechten worden voorgeleend. <br> Het systeem is op dit moment nog in de bouw.</p>
        </div>
        </body>
    </html>