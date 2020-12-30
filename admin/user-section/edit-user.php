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

    header('Location: ../logout.php'); // user logs out
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

            <div>
                <label class="user-label" for="gebruikersnaam">Gebruikersnaam*: </label>
                <input class="user-field" id="gebruikersnaam" name="username" value="<?= $user['username'] ?>"
            </div>

            <div>
                <h1 class="user-label">Admin?*</h1>
                <input class="user-field" type="radio" id="yes-admin" name="admin" value="1"
                    <?php
                        if ($user['admin'] == 1) {
                            echo " checked";
                        }
                    ?>
                >
                <label class="user-label radio-label" for="yes-admin">Ja</label>

                <input class="user-field" type="radio" id="no-admin" name="admin" value="0"
                    <?php
                    if ($user['admin'] == 0) {
                        echo " checked";
                    }
                    ?>
                >
                <label class="user-label radio-label" for="no-admin">Nee</label>
            </div>

            <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
            <input class="user-field" type="submit" name="submit" value="Wijzigingen toepassen">

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
