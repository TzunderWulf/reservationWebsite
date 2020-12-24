<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: ../login.php');
    exit();
} elseif ($_SESSION['admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

require_once '../../includes/config.php';

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
</head>

<body class="container">
    <div class="item-a">
        <img src="../../images/header.png" alt="header image">
    </div>

    <div class="user">
        <h2>Welkom, <?=$_SESSION['username']?>!</h2>
        <h3><?=date('d-m-Y H:i')?></h3>
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

    <div class="item-b">
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
    </div>
    </body>
</html>
