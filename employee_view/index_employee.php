<?php
session_start();

require_once('../includes/config.php');
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

$currentWeekQuery = "SELECT id,customerid,type_reservation,date,time,car, description
    FROM reservations
    WHERE date
    BETWEEN CAST(timestampadd(SQL_TSI_DAY, -(dayofweek(curdate())-2), curdate()) AS date)
        and CAST(timestampadd(SQL_TSI_DAY, 5-(dayofweek(curdate())-1), curdate()) AS date)
        ORDER BY date, time ASC";
$currentWeekResult = mysqli_query($db, $currentWeekQuery);

$currentDayQuery = "SELECT id,customerid,type_reservation,date,time,car, description
                    FROM reservations 
                    WHERE date = '2020-12-16'
                    ORDER BY time ASC";
$currentDayResult = mysqli_query($db, $currentDayQuery);

$reservationsWeek = [];
// loop trough with while
while($row = mysqli_fetch_assoc($currentWeekResult)) {
    $reservationsWeek[] = $row;
    break;
}

$reservationsToday = [];
    // loop trough with while
    while($row = mysqli_fetch_assoc($currentDayResult)) {
        $reservationsToday[] = $row;
        break;
    }
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
        <header>
            <div class="left">
                <img src="../logo_klein.jpg" alt="logo">
                <h1 id="title">Garage Nieuw Rijswijk</h1>
            </div>
            <div class="right">
                <h3>Welkom, <?=$_SESSION['username']?></h3>
                <h3>Het is vandaag <?=$currentDateNL?></h3>
            </div>

            <a href="x.php">
                <button>?</button>
            </a>

            <a href="logout.php">
                <button>Uitloggen</button>
            </a>
        </header>

        <main>
            <div class="left">
            <h3>Afspraken voor vandaag, <?=$currentDateNL?></h3>
            <?php foreach ($currentDayResult as $reservation) { ?>
                <a class="reservation" href="detail.php?index=<?=$reservation['id']?>">
                    <div class="reservation">
                        <p><?=$reservation['type_reservation']?></p>
                        <p><?=date('H:i',strtotime($reservation['time']))?></p>
                        <p><?php if (isset($reservation['description'])) { ?>
                            Opmerkingen: <?=$reservation['description']?>
                        <?php } ?></p>
                        <p><?php if (isset($reservation['car'])) { ?>
                            Autokeuze: <?=$reservation['car']?>
                        <?php } ?></p>
                    </div>
                </a>
            <?php } ?>
            </div>

            <div class="right">
            <h3>Afspraken voor komende week <?=date('W')?></h3>
            <?php foreach ($currentWeekResult as $reservation) { ?>
                <a class="reservation" href="detail.php?index=<?=$reservation['id']?>">
                    <div class="reservation">
                        <p><?=$reservation['type_reservation']?></p>
                        <p><?=date('d-m-Y',strtotime($reservation['date']))?> <?=date('H:i',strtotime($reservation['time']))?></p>
                        <p><?php if (isset($reservation['description'])) { ?>
                            Opmerkingen: <?=$reservation['description']?>
                        <?php } ?></p>
                        <p><?php if (isset($reservation['car'])) { ?>
                            Autokeuze: <?=$reservation['car']?>
                        <?php } ?></p>
                    </div>
                </a>
            <?php } ?>
            </div>
        </main>

        <footer>

        </footer>
    </body>
</html>

