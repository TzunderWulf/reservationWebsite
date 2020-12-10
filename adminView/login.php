<?php
    $username = '';
    $password = '';

    $usernameErr = '';
    $passwordErr = '';

    if (isset($_POST['submit'])) {
        $validForm = true; // boolean to check if form is valid, changes based on if field is empty

        // validation for the name input
        if (!isset($_POST['username']) || $_POST['username'] === '') {
            $validForm = false;
            $usernameErr = 'Geen gebruikersnaam ingevuld.';
        } else {
            $username = htmlspecialchars($_POST['username']);
        }

        // validation for the email input
        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $validForm = false;
            $passwordErr = 'Geen wachtwoord ingevuld.';
        } else {
            $password = htmlspecialchars($_POST['password']);
        }

        if ($validForm){
            header('Location: startScreen.php');
        }
    }
?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Inloggen</title>
            <link rel="stylesheet" href="../styles/admin.css">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
            <h1>Welkom, log hieronder in.</h1>
            <form action="" method="post">
                <label for="gebruikersnaam">Gebruikersnaam: </label>
                <input type="text" id="gebruikersnaam" name="username" value="<?=
                htmlspecialchars($username, ENT_QUOTES);?>">
                <p class="error"><?=$usernameErr;?></p><br>

                <label for="wachtwoord">Wachtwoord: </label>
                <input type="password" id="wachtwoord" name="password">
                <p class="error"><?=$passwordErr;?></p><br>

                <input type="submit" name="submit" value="Inloggen">
            </form>
        </body>
    </html>