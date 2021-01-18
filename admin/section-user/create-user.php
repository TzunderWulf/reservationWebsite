<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

require_once('../../includes/config.php'); // to connect to database

$username = $password = $confirmPassword = ""; // variables for inputs
$errors = []; // empty array for errors

if (isset($_POST['submit'])) {

    // validating the username
    if (empty($_POST['username'])) {
        $errors['username'] = "Gelieve dit veld in te vullen.";
    } else {
        $usernameCheck = "SELECT id 
                          FROM users 
                          WHERE username = ?";
        if ($stmt = mysqli_prepare($db, $usernameCheck)) {
            mysqli_stmt_bind_param($stmt, "s", $paramUsername);
            $paramUsername = htmlspecialchars($_POST['username']);

            // attempt to execute
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt); // storing the result

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $errors['username'] = "Deze gebruikersnaam is al genomen.";
                } else {
                    $username = htmlspecialchars($_POST['username']);
                }
            } else {
                $errors['general'] = "Er is iets misgegaan, probeer het later opnieuw.";
            }
            mysqli_stmt_close($stmt); // close statement
        }
    }

    // validating the password and confirm password
    if (empty($_POST['password'])) {
        $errors['password'] = "Gelieve dit veld in te vullen.";
    } elseif (strlen($_POST['password']) < 10) {
        $errors['password'] = "Wachtwoord moet minimaal langer zijn dan 10 karakters";
    } else {
        $password = htmlspecialchars($_POST['password']);
    }

    if (empty($_POST['confirm-password'])) {
        $errors['confirm-password'] = "Gelieve dit veld in te vullen.";
    } elseif (empty($errors['password']) && $_POST['confirm-password'] === $_POST['password']) {
        $errors['general'] = "Er is iets misgegaan.";
    }

    if (empty($_POST['admin'])) {
        $errors['admin'] = "Gelieve een optie te kiezen.";
    }

    if (empty($errors)) {
        // preparing insert statement
        $addUser = sprintf("INSERT INTO users (username, password) 
                    VALUES ('%s', '%s')",
                    $db->real_escape_string($username),
                    $db->real_escape_string($password));
        if ($stmt = mysqli_prepare($db, $addUser)) {
            // bind variables
            mysqli_stmt_bind_param($stmt, "ss", $paramUsername, $paramPassword);
            $paramUsername = $username;
            $paramPassword = password_hash($password, PASSWORD_DEFAULT); // create hash for password

            // attempt to execute statment
            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php');
                // exit();
            } else {
                $errors['general'] = "Er is iets misgegaan, probeer het later opnieuw.";
            }
            mysqli_stmt_close($stmt); // close connection
        }
    }
    mysqli_close($db);
}
?>

<!doctype html>
<html lang="nl">
    <head>

        <title>Gebruiker aanmaken</title>
        <link rel="stylesheet" href="../../styles/stylesheet-forms.css">

        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">

    </head>

    <body>
        <h1>Gebruiker aanmaken</h1>
        <p class="error-message"><?php isset($errors['general']) ? print_r($errors['general']): "" ?></p>

        <form action="" method="post">
            <div>
                <label for="gebruikersnaam">Gebruikersnaam: </label>
                <input type="text" id="gebruikersnaam" name="username">
                <p class="error-message"><?php isset($errors['username']) ? print_r($errors['username']) : "" ?></p>
            </div>

            <div>
                <label for="wachtwoord">Wachtwoord: </label>
                <input type="password" id="wachtwoord" name="password">
                <p class="error-message"><?php isset($errors['password']) ? print_r($errors['password']) : "" ?></p>
            </div>

            <div>
                <label for="wachtwoord-bevestigen">Wachtwoord bevestigen: </label>
                <input type="password" id="wachtwoord-bevestigen" name="password-comfirm">
                <p class="error-message"><?php isset($errors['confirm-password']) ? print_r($errors['confirm-password']) : "" ?></p>
            </div>

            <div>
                <h4 id="admin-rights">Adminrechten: </h4>
                <input type="radio" id="yes-admin" name="admin" value="1">
                <label for="yes-admin">Ja</label>

                <input type="radio" id="no-admin" name="admin" value="0">
                <label for="no-admin">Nee</label>
                <p class="error-message"><?php isset($errors['admin']) ? print_r($errors['admin']) : "" ?></p>
            </div>

            <input type="submit" name="submit" value="Aanmaken">
        </form>

        <footer>
            <p>
                Aan dit systeem kunnen geen rechten worden voorgeleend. <br>
                Het systeem is op dit moment nog in de bouw.
            </p>
        </footer>

    </body>
</html>
