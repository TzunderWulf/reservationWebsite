<?php
session_start();

// Checks if user is already logged in, if so send trough
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header('Location: index.php');
    exit();
}

require_once('../includes/config.php'); // To connect to database

// Variables for inputs and error
$username = $password = "";
$usernameErr = $passwordErr = "";

if (isset($_POST['submit'])) {
    if (empty(trim($_POST['username']))) {
        $usernameErr = "Dit veld kan niet leeg zijn.";
    } else {
        $username = trim($_POST['username']);
    }
    if (empty(trim($_POST['password']))) {
        $passwordErr = "Dit veld kan niet leeg zijn.";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        $sql = "SELECT id, username, password, admin 
                     FROM users 
                     WHERE username = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $paramUsername);
            $paramUsername = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $admin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["admin"] = $admin;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $passwordErr = "Dit veld is verkeerd ingevoerd.";
                        }
                    }
                } else {
                    $usernameErr = "Deze gebruikersnaam is niet gevonden.";
                }
            } else {
                echo "Er is iets verkeerd gegaan. Probeer het later opnieuw.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($db);
}