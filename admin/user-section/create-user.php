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
        $errors['username'] = "Dit veld mag niet leeg zijn.";
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
                $errors['database'] = "Er is iets misgegaan, probeer het later opnieuw.";
            }
            mysqli_stmt_close($stmt); // close statement
        }
    }

    // validating the password and confirm password
    if (empty($_POST['password'])) {
        $errors['password'] = "Dit veld mag niet leeg zijn.";
    } elseif (strlen($_POST['password']) < 10) {
        $errors['password'] = "Wachtwoord moet minimaal langer zijn dan 10 karakters";
    } else {
        $password = htmlspecialchars($_POST['password']);
    }

    if (empty($_POST['confirm-password'])) {
        $errors['confirm-password'] = "Dit veld mag niet leeg zijn.";
    } elseif (empty($errors['password']) && $_POST['confirm-password'] === $_POST['password']) {
        $errors['confirm-password'] = "Wachtwoorden komen niet overeen.";
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
                $errors['database'] = "Er is iets misgegaan, probeer het later opnieuw.";
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
    </head>

    <body>
        <h1>Gebruiker aanmaken</h1>
        <p class="error-message"><?php isset($errors['database']) ? print_r($errors['database']): ""?></p>

        <form action="" method="post">
            <div>
                <label for="gebruikersnaam">Gebruikersnaam: </label>
                <input type="text" id="gebruikersnaam" name="username">
                <p class="error-message"><?php isset($errors['username']) ? print_r($errors['username']) : ""?></p>
            </div>

            <div>
                <label for="wachtwoord">Wachtwoord: </label>
                <input type="password" id="wachtwoord" name="password">
                <p class="error-message"><?php isset($errors['password']) ? print_r($errors['password']) : ""?></p>
            </div>

            <div>
                <label for="wachtwoord-bevestigen">Wachtwoord bevestigen: </label>
                <input type="password" id="wachtwoord-bevestigen" name="password-comfirm">
                <p class="error-message"><?php isset($errors['confirm-password']) ? print_r($errors['confirm-password']) : "" ?></p>
            </div>

            <input type="submit" name="submit" value="Aanmaken">
        </form>
    </body>
</html>
