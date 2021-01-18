<?php

session_start(); // start a session (for session variables)

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    // user is not logged in
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    // user is logged in, but not an admin
    header('Location: ../index.php');
    exit();
}

require_once '../../includes/config.php'; // to connect to database

$username = $admin = "";
$errors = [];

if (isset($_POST['submit'])) {
    // first check if fields are not empty
    if (empty($_POST['username'])) {
        $errors['username'] = "Gelieve dit veld in te vullen.";
    } else {
        $username = $_POST['username']; // no echo, so no htmlspecialchars
    }

    if ($_POST['admin-value'] == 1 || $_POST['admin-value'] == 0) {
        $admin = $_POST['admin-value']; // no echo, so no htmlspecialchars
    } else {
        $errors['admin'] = "Gelieve een optie te kiezen1.";
    }

    // check if id still exist and has a value
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $errors['id'] = "Er is iets misgegaan.";
    }

    $user = ['username' => $username, 'admin' => $admin, 'id' => $_POST['id']]; // make sure form is still intact

    if (empty($errors)) {
        // make variables safe to insert into database
        $username       = mysqli_escape_string($db, $username);
        $admin          = mysqli_escape_string($db, $admin);


        $query          = "UPDATE users
                           SET username = '$username', admin = '$admin'
                           WHERE id = " . mysqli_escape_string($db, $_POST['id']);
        $result         = mysqli_query($db, $query);

        if ($result) {
            header('Location: ../logout.php');
            exit();
        } else {
            $errors['database'] = "Er is iets misgegaan.";
        }
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT id, username, admin 
              FROM users 
              WHERE id = " . mysqli_escape_string($db, $id);
    $result = mysqli_query($db, $query);

    // make sure id (user) exists in the database
    if (mysqli_num_rows($result) == 1) {
        $user           = mysqli_fetch_assoc($result);
    } else {
        header('Location: overview-user.php');
        exit();
    }
} else {
    // the form is neither submitted, nor is there an id in the URL
    header('Location: overview-user.php');
    exit();
}

?>

<!doctype html>
<html lang="nl">
<head>
    <title>Gebruiker aanpassen</title>
    <link rel="stylesheet" href="../../styles/stylesheet-forms.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
</head>

<body class="container">
<header>
    <img id="header-img" src="../../images/header.png" alt="header image">
</header>
<main>
    <form action="" method="post">
        <h1>Gebruiker: <?= $user['username'] ?></h1>
        <p class="error-message"><?= isset($errors['database']) ? $errors['database'] : "" ?></p>
        <div class="form-field">
            <label for="username">Gebruikersnaam: </label>
            <input type="text" id="username" name="username" value="<?= $user['username'] ?>">
            <p class="error-message"><?= isset($errors['username']) ? $errors['username'] : ""?></p>
        </div>
        <div class="form-field">
            <h1 class="user-label">Admin?*</h1>
            <input type="radio" id="admin-value-true" name="admin-value" value="1"
                <?= $user['admin'] == 1 ? " checked" : "" ?>
            >
            <label for="admin-value-true">Ja</label>
            <input type="radio" id="admin-value-false" name="admin-value" value="0"
                <?= $user['admin'] == 0 ? " checked" : "" ?>
            >
            <label for="admin-value-false">Nee</label>
            <p class="error-message"><?= isset($errors['admin']) ? $errors['admin'] : ""?></p>
        </div>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input class="" type="submit" name="submit" value="Wijzigingen toepassen">
        <a class="link-button button" href="overview-user.php">Terug</a>
    </form>
</main>
<footer>
    <p>
        Aan dit systeem kunnen geen rechten worden voorgeleend. <br>
        Het systeem is op dit moment nog in de bouw.
    </p>
</footer>
</body>
</html>