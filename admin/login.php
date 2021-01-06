<?php
require_once("../includes/validation-login.php")
?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Inloggen</title>
            <link rel="stylesheet" href="../styles/stylesheet-forms.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body class="container">
        <header>
            <img id="header-img" src="../images/header.png" alt="header image">
        </header>

        <main>
            <form action="" method="post">
                <h1>Welkom, log hieronder in.</h1>

                <div>
                    <label class="login-label" for="gebruikersnaam">Gebruikersnaam:</label>
                    <input class="login-input" type="text" id="gebruikersnaam" name="username" value="<?=$username?>">
                    <p class="error-message"><?=$usernameErr?></p>
                </div>

                <div>
                    <label class="login-label" for="wachtwoord">Wachtwoord:</label>
                    <input class="login-input" type="password" id="wachtwoord" name="password">
                    <p class="error-message"><?=$passwordErr?></p>
                    <p id="warning-text">Let op, capslock is aan</p>
                </div>

                <div>
                    <input class="login-input" type="submit" name="submit" value="Inloggen">
                </div>

                <a class="link-button button" href="../index.php">Maak een reservering</a>
            </form>
        </main>

        <footer>
            <p>Aan dit systeem kunnen geen rechten worden voorgeleend. <br> Het systeem is op dit moment nog in de bouw.</p>
        </footer>

        <script src="../scripts/main.js"></script>
        </body>
    </html>