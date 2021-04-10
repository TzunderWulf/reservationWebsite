<?php

session_start(); // start a session, to get session variables

// check if user is logged in, and if user is an admin
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

require_once('../../includes/config.php'); // to connect to database

$username = $password = $confirmPassword = $admin = "";
$errors = [];

if (isset($_POST['submit'])) {
    // validating the username and checking availability
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

    if (empty($_POST['admin-value'])) {
        $errors['admin'] = "Gelieve een optie te kiezen.";
    } else {
        $admin = $_POST['admin-value'];
    }

    // inserting new user into database
    if (empty($errors)) {
        // preparing insert statement
        $username = mysqli_escape_string($db, $username);
        $password = mysqli_escape_string($db, $password);
        $admin = mysqli_escape_string($db, $admin);

        $password = password_hash($password, PASSWORD_DEFAULT); // create hash for password

        $query = "INSERT INTO users (username, password, admin) 
                  VALUES ('$username', '$password' '$admin')";
        $result = mysqli_query($db, $query);
        // check if data is added
        if ($result) {
            header('Location: overview-user.php');
            exit();
        } else {
            $errors['general'] = "Er is iets misgegaan, probeer het later opnieuw.";
        }
    }
    mysqli_close($db);
}
?>

<!doctype html>
<html lang="nl">
<head>
    <title>Gebruiker aanmaken</title>
    <link rel="stylesheet" href="../../css/stylesheet-forms.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
</head>

<body class="container">
    <header>
        <img id="header-img" src="../../images/header.png" alt="Garage Nieuw Rijswijk">
    </header>
    <main>
        <form class="basic-form" action="" method="post">
            <h1>Gebruiker aanmaken</h1>
            <p class="error-message"><?php isset($errors['general']) ? print_r($errors['general']): "" ?></p>
            <div class="form-field">
                <label class="basic-label" for="username">Gebruikersnaam: </label>
                <input class="basic-input" type="text" id="username" name="username">
                <p class="error-message"><?php isset($errors['username']) ? print_r($errors['username']) : "" ?></p>
            </div>
            <div class="form-field">
                <label class="basic-label" for="password">Wachtwoord: </label>
                <input class="basic-input" type="password" id="password" name="password">
                <p class="error-message"><?php isset($errors['password']) ? print_r($errors['password']) : "" ?></p>
            </div>
            <div class="form-field">
                <label class="basic-label" for="password-comfirm">Wachtwoord bevestigen: </label>
                <input class="basic-input" type="password" id="password-comfirm"
                       name="password-comfirm">
                <p class="error-message"><?php isset($errors['confirm-password']) ? print_r($errors['confirm-password']) : "" ?></p>
            </div>
            <div class="form-field">
                <h4 class="basic-label">Adminrechten: </h4>
                <div class="basic-input">
                    <input class="basic-radio-input" type="radio" id="admin-value-true" name="admin-value" value="1">
                    <label class="basic-label" for="admin-value-true">Ja</label>
                    <input class="basic-radio-input" type="radio" id="admin-value-false" name="admin" value="0">
                    <label class="basic-label" for="admin-value-false">Nee</label>
                </div>
                <p class="error-message"><?php isset($errors['admin']) ? print_r($errors['admin']) : "" ?></p>
            </div>
            <input class="basic-input basic-submit" type="submit" name="submit" value="Aanmaken">
            <a class="link-button button" href="overview-user.php">Terug</a>
        </form>
    </main>
    <footer>
        <p>Aan dit systeem kunnen geen rechten worden voorgeleend.</p>
        <p>Het systeem is op dit moment nog in de bouw.</p>
    </footer>
</body>
</html>