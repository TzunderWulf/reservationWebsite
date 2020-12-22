<?php
session_start();

require_once('../includes/config.php');

function timesArray(string $start, string $end, int $interval) {
    $times = [];
    $time = strtotime($start);
    $timeToAdd = 30;

    while($time <= strtotime($end)) {
        $times[] = date('H:i', $time);
        $time +=  60 * $timeToAdd;
    }
    return $times;
}

setlocale(LC_ALL, 'nld_nld'); // set local to dutch

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$date = date ('Y-m-d');

// showing the date in dutch
$currentDate = strftime("%A %e %B", mktime(0, 0, 0, date('m'), date('d'),
    date('y')));

$monday = date("Y-m-d", strtotime('monday this week'));
$friday = date("Y-m-d", strtotime('friday this week'));

// getting the reservations for this week
$weekQuery = "SELECT id,customerid,type_reservation,date,time,car,description
                FROM reservations
                WHERE date
                BETWEEN '$monday'
                    AND '$friday'
                    ORDER BY time ASC";
$weekResult = mysqli_query($db, $weekQuery)
    or die('Error '.mysqli_error($db).' with query '. $weekQuery);

$currentDay = date('Y-m-d');
$dayQuery = "SELECT id,customerid,type_reservation,date,time,car, description
                                FROM reservations
                                    WHERE date = '$currentDay'
                                    ORDER BY time ASC";
$dayResult = mysqli_query($db, $dayQuery)
    or die('Error ' .mysqli_error($db).' with query '. $dayQuery);

$reservationsWeek = [];
// loop trough week reservations with while
while($row = mysqli_fetch_assoc($weekResult)) {
    $reservationsWeek[] = $row;
    break;
}

$reservationsToday = [];
// loop trough today's reservations with while
while($row = mysqli_fetch_assoc($dayResult)) {
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
<div class="item-a">
    <img src="../images/header.png" alt="header image">
</div>

<div id="user">
    <h2>Welkom, <?=$_SESSION['username']?>!</h2>
    <h3><?=date('d-m-Y H:i')?></h3>
    <?php if ($_SESSION['admin'] === 1) { ?>
        <a class="link-button" href="user-section/create-user.php">
            <div class="user-button">Gebruiker aanmaken</div>
        </a>
    <?php } ?>
    <a class="link-button" href="">
        <div class="user-button">Hulp</div>
    </a>
    <a class="link-button" href="logout.php">
        <div class="user-button">Uitloggen</div>
    </a>
</div>

<div class="item-b">
    <h2>Afspraken voor de week <?=$week = date('W')?></h2>
    <div class="row">
        <?php for($d=-1;$d<5;$d++) { ?>
            <?php if ($d == -1) { ?>
                <div class="column time-column"></div>
            <?php } else { ?>
                <div class="column">
                    <div><?=strftime('%A', strtotime($monday . " + $d days"))?></div>
                    <div><?=strftime('%e %B', strtotime($monday . " + $d days"))?></div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>


    <?php foreach ($times as $row => $time) { ?>
        <div class="row">
            <?php for($i=-1;$i<5;$i++) { ?>
                <?php if ($i == -1) { ?>
                    <div class="column time-column"><?=$time?></div>
                <?php } else { ?>
                    <div class="column">
                        <?php foreach ($weekResult as $reservation) { ?>
                            <?php if (date('N', strtotime($reservation['date']))-1 == $i
                                      && strtotime($time) == strtotime($reservation['time'])) { ?>
                                    <a class="reservation" href="detail.php?index=<?=$reservation['id']?>">
                                        <div>
                                            <?=$reservation['type_reservation']?> <br>
                                            <?=date('H:i', strtotime($reservation['time']))?>
                                        </div>
                                    </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
    <div class="item-c">
        <h2>Afspraken voor vandaag <?=$currentDate?></h2>
        <?php foreach ($dayResult as $todayReservation) { ?>
            <a class="link-button" href="detail.php?index=<?=$todayReservation['id']?>">
                <div class="reservation-today">
                    <p><?=$todayReservation['type_reservation']?></p>
                    <p><?=date('H:i',strtotime($todayReservation['time']))?></p>
                    <p><?php if (isset($todayReservation['description'])) { ?>
                            Opmerkingen: <?=$todayReservation['description']?>
                        <?php } ?></p>
                    <p><?php if (isset($todayReservation['car'])) { ?>
                            Autokeuze: <?=$todayReservation['car']?>
                        <?php } ?></p>
                </div>
            </a>
        <?php } ?>
    </div>

<div class="item-d">
    <p>Aan dit systeem kunnen geen rechten worden voorgeleend. <br> Het systeem is op dit moment nog in de bouw.</p>
</div>
</body>
</html>