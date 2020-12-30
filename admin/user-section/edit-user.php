<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}
require_once '../../includes/config.php'; // connect to database
if (isset($_POST['submit'])) {
    $username = mysqli_escape_string($db, htmlspecialchars($_POST['username']));
    $admin = mysqli_escape_string($db, htmlspecialchars($_POST['admin']));
    $query = "UPDATE users SET username = '$username', admin = '$admin' WHERE id = " . mysqli_escape_string($db, $_POST['id']);
    $result = mysqli_query($db, $query)
        or die ("Something went wrong. " . $query);
    mysqli_close($db); // close connection

    header('Location: overview-user.php'); // redirect to user overview
    exit();
} elseif (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "SELECT id, username, admin FROM users WHERE id = " . mysqli_escape_string($db, $userId);
    $result = mysqli_query($db, $query)
        or die ("Something went wrong. " . $query);

    // check if user exists in database, if not redirect back to overview
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header('Location: overview-user.php');
        exit();
    }
} else {
    header('Location: overview-user.php');
    exit();
}
?>

<!doctype html>
<html lang="nl">
<head>

    <title>Gebruiker verwijderen</title>
    <link rel="stylesheet" href="../../styles/stylesheet-login.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">

</head>

<body class="container">
<header>
    <img src="../../images/header.png" alt="header image">
</header>

<main>
    <form id="delete" action="" method="post">
        <h1>Gebruiker: <?= $user['username'] ?></h1>
        <div class="field-input">
            <label for="gebruikersnaam">Gebruikersnaam: </label>
            <input type="text" id="gebruikersnaam" name="username" value="<?= $user['username'] ?>">
        </div>
        <div class="field-input">
            <label>Is de gebruiker een admin? </label>
            <input type="radio" id="yes-admin" name="admin" value="1"
            <?php
                if ($user['admin'] == 1) {
                    echo " checked";
                }
            ?>>
            <label for="yes-admin">Ja</label>

            <input type="radio" id="no-admin" name="admin" value="0"
            <?php
                if ($user['admin'] != 1) {
                    echo " checked";
                }
            ?>>
            <label for="no-admin">Nee</label>
        </div>
        <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
        <div>
            <input type="submit" name="submit" value="Update">
        </div>
        <a class="link-button" href="overview-user.php">
            <div class="button">
                <h3>Terug</h3>
            </div>
        </a>
    </form>
</main>
</body>
</html>
