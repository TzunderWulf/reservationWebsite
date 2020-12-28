<?php
session_start();
require_once '../../includes/config.php'; // to connect to database

// make sure user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

// getting all users from database
$query = "SELECT id, username, admin FROM users";
$result = mysqli_query($db, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
    break;
}
?>

<!doctype>
<html lang="nl">
<head>

    <title>Gebruikers</title>
    <link rel="stylesheet" href="../../styles/stylesheet-admin.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">

</head>

<body class="container">

    <header class="item-a">
        <img src="../../images/header.png" alt="header image">
    </header>

    <div class="user">
        <h2>Welkom, <?=$_SESSION['username']?>!</h2>
        <h3><?=date('d-m-Y H:i')?></h3>

        <!-- if user is an admin show button for user overview -->
        <?php if ($_SESSION['admin'] === 1) { ?>
            <a class="link-button" href="overview-user.php">
                <div class="user-button">Gebruikers</div>
            </a>
        <?php } ?>

        <a class="link-button" href="">
            <div class="user-button">Hulp</div>
        </a>

        <a class="link-button" href="../logout.php">
            <div class="user-button">Uitloggen</div>
        </a>
    </div>

    <main class="item-b">
        <div class="row">
            <div class="column">
                <p>ID</p>
            </div>
            <div class="column">
                <p>Gebruikersnaam</p>
            </div>
            <div class="column">
                <p>Admin</p>
            </div>
            <div class="column"></div>
            <div class="column"></div>
        </div>

        <?php foreach ($result as $row => $user) { ?>
            <div class="row">
                <div class="column">
                    <p><?=$user['id']?></p>
                </div>
                <div class="column">
                    <p><?=$user['username']?></p>
                </div>
                <div class="column">
                    <p><?= $user['admin'] == 1 ? "Ja" : "Nee"?></p>
                </div>
                <div class="column">
                    <a href="edit-user.php?id=<?=$user['id']?>">
                        <p>Aanpassen</p>
                    </a>
                </div>
                <div class="column">
                    <a href="delete-user.php?id=<?=$user['id']?>">
                        <p>Verwijderen</p>
                    </a>
                </div>
            </div>
        <?php } ?>
    </main>

    <!-- sidebar -->
    <div class="item-c">
        <div id="options">
            <a class="link-button" href="create-user.php">
                <div class="button">
                    <h3>Gebruiker toevoegen</h3>
                </div>
            </a>
            <a class="link-button" href="../index.php">
                <div class="button">
                    <h3>Terug</h3>
                </div>
            </a>
        </div>
    </div>

    <footer class="item-d">
        <p>
            Aan dit systeem kunnen geen rechten worden voorgeleend. <br>
            Het systeem is op dit moment nog in de bouw.
        </p>
    </footer>

    </body>
</html>
