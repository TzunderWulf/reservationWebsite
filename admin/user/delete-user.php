<?php

session_start(); // start a session, to get session variables

// check if user is logged in, and if user is admin
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../../includes/config.php'; // connect to database

if (isset($_POST['submit'])) {
    $query = "DELETE FROM users WHERE id = " . mysqli_escape_string($db, $_POST['id']);
    $result = mysqli_query($db, $query)
        or die ("Something went wrong. " . $query);
    mysqli_close($db); // close connection

    header('Location: overview-user.php'); // redirect to user overview
    exit();
} elseif (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "SELECT id, username FROM users WHERE id = " . mysqli_escape_string($db, $userId);
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
            <h1 class="title-form">Wilt u <?= $user['username'] ?> verwijderen?</h1>
            <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
            <input class="basic-input basic-submit" type="submit" name="submit" value="Verwijderen">
            <a class="link-button button" href="overview-user.php">Terug</a>
        </form>
    </main>
    <footer>
        <p>Aan dit systeem kunnen geen rechten worden voorgeleend.</p>
        <p>Het systeem is op dit moment nog in de bouw.</p>
    </footer>
</body>
</html>
