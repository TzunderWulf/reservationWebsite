<?php
session_start();
require_once '../includes/config.php'; // to connect to database
require_once '../includes/times-schedule.php'; // setting up times for time column

// make sure user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: login.php');
    exit();
}

setlocale(LC_ALL, 'nld_nld'); // set local to dutch

// show the date in Dutch
$dateDutch = strftime("%A %e %B", mktime(0, 0, 0, date('m'), date('d'),
    date('y')));

$monday = date("Y-m-d", strtotime("monday this week"));
$friday = date("Y-m-d", strtotime($monday . "+ 4 days"));

// getting the reservations for this week
$query = "SELECT id,customerid,type_reservation,date,time,car,description
                FROM reservations
                WHERE date
                BETWEEN '$monday'
                    AND '$friday'
                    ORDER BY time ASC";
$resultWeek = mysqli_query($db, $query)
    or die('Error '.mysqli_error($db).' with query '. $query);

$reservations = [];
// loop trough week reservations with while
while($row = mysqli_fetch_assoc($resultWeek)) {
    $reservations[] = $row;
    break;
}

$currentDay = date('Y-m-d');
$query = "SELECT id,customerid,type_reservation,date,time,car, description
                                FROM reservations
                                    WHERE date = '$currentDay'
                                    ORDER BY time ASC";
$result = mysqli_query($db, $query)
    or die('Error ' .mysqli_error($db).' with query '. $query);

$reservationsToday = [];
// loop trough today's reservations with while
while($row = mysqli_fetch_assoc($result)) {
    $reservationsToday[] = $row;
    break;
}

$times = timesArray('08:00', '17:30', 15);

?>

<!doctype html>
<html lang="nl">
<head>

    <title>Homepage</title>
    <link rel="stylesheet" href="../styles/stylesheet-admin.css">

    <!-- Google Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">

</head>

<body class="container">

    <header class="item-a">
        <img src="../images/header.png" alt="header image">
    </header>

    <div class="user">
        <h2>Welkom, <?= $_SESSION['username'] ?>!</h2>
        <h3><?=date('d-m-Y H:i')?></h3>

        <!-- if user is an admin show button for user overview -->
        <?php if ($_SESSION['admin'] === 1) { ?>
            <a class="link-button" href="user-section/overview-user.php">
                <div class="user-button">Gebruikers</div>
            </a>
        <?php } ?>

        <a class="link-button" href="">
            <div class="user-button">Hulp</div>
        </a>

        <a class="link-button" href="logout.php">
            <div class="user-button">Uitloggen</div>
        </a>
    </div>

    <main class="item-b">
        <h2>Reserveringen voor de week <?= date('W') ?></h2>

        <!-- row for days of the week -->
        <div class="row">
            <?php for($d=-1;$d<5;$d++) { ?>
                <?php if ($d == -1) { ?>
                    <div class="column time-column"></div>
                <?php } else { ?>
                    <div class="column">
                        <div><?= strftime('%A', strtotime($monday . " + $d days")) ?></div>
                        <div><?= strftime('%e %B', strtotime($monday . " + $d days")) ?></div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <!-- times column -->
        <?php foreach ($times as $row => $time) { ?>
            <div class="row">
                <?php for($i=-1;$i<5;$i++) { ?>
                    <?php if ($i == -1) { ?>
                        <div class="column time-column"><?= $time ?></div>
                    <?php } else { ?>
                        <div class="column">
                            <?php foreach ($resultWeek as $reservation) { ?>
                                <?php if (date('N', strtotime($reservation['date']))-1 == $i
                                      && strtotime($time) == strtotime($reservation['time'])) { ?>
                                    <a class="reservation" href="detail.php?index=<?= $reservation['id'] ?>">
                                        <div>
                                            <?= $reservation['type_reservation'] ?> <br>
                                            <?= date('H:i', strtotime($reservation['time'])) ?>
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </main>

    <!-- sidebar -->
    <div class="item-c">
        <h2>Reserveringen voor vandaag <?= $dateDutch ?></h2>
        <?php foreach ($result as $reservation) { ?>
            <a class="link-button" href="detail.php?index=<?=$reservation['id']?>">
                <div class="reservation-today">
                    <p><?= $reservation['type_reservation']?> </p>
                    <p><?= date('H:i',strtotime($reservation['time'])) ?></p>
                    <p>
                        <?php if (isset($reservation['description'])) { ?>
                            Opmerkingen: <?= $reservation['description'] ?>
                        <?php } ?>
                    </p>
                    <p>
                        <?php if (isset($reservation['car'])) { ?>
                            Autokeuze: <?= $reservation['car'] ?>
                        <?php } ?>
                    </p>
                </div>
            </a>
        <?php } ?>
    </div>

    <footer class="item-d">
        <p>
            Aan dit systeem kunnen geen rechten worden voorgeleend. <br>
            Het systeem is op dit moment nog in de bouw.
        </p>
    </footer>

</body>
</html>