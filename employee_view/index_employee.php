<?php
session_start();
setlocale(LC_ALL, 'nld_nld'); // set local to dutch

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// showing the date in dutch
$currentMonth = date('m');
$currentDate = date('d');
$currentYear = date('y');
$currentDateNL = strftime("%A %e %B", mktime(0, 0, 0, $currentMonth, $currentDate, $currentYear));
?>

<!doctype html>
<html lang="nl">
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../styles/stylesheet_employee.css">

        <!-- Google Font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    </head>

    <body>
        <main>
            <h2>Welkom, <?=$_SESSION['username']?></h2>
            <h3>Het is vandaag <?=$currentDateNL?></h3>

            <a href="logout.php">
                <button>Uitloggen</button>
            </a>

            <p>Afspraken voor vandaag: <?=$currentDateNL?></p>
            <p>TEST AFSPRAAK MAN</p>

            <p>Afspraken voor komende week: <?=date('W')?></p>
            <p>TEST AFSPRAAK MAN</p>
        </main>

        <footer>

        </footer>
    </body>
</html>

