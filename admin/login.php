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
        <img id="header-img" src="../images/header.png" alt="Garage Nieuw Rijswijk">
    </header>
    <main>
        <form class="basic-form" action="" method="post">
            <h1 class="title-form">Welkom, log hieronder in.</h1>
            <div class="form-field">
                <label class="basic-label" for="username">Gebruikersnaam:</label>
                <input class="basic-input" type="text" id="username" name="username"
                       value="<?=$username?>">
                <p class="error-message"><?=$usernameErr?></p>
            </div>
            <div class="form-field">
                <label class="basic-label" for="password">Wachtwoord:</label>
                <input class="basic-input" type="password" id="password" name="password">
                <p class="error-message"><?=$passwordErr?></p>
                <p id="warning-text">Let op, capslock is aan</p>
            </div>
            <input class="basic-input basic-submit" type="submit" name="submit" value="Inloggen">
            <a class="link-button button" href="../index.php">Maak een reservering</a>
        </form>
    </main>
    <footer>
        <p>Aan dit systeem kunnen geen rechten worden voorgeleend.</p>
        <p>Het systeem is op dit moment nog in de bouw.</p>
    </footer>
        <script src="../scripts/main.js"></script>
</body>
</html>