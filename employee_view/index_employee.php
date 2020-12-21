<?php
session_start();

require_once('../includes/config.php');
require_once('../includes/weekschedule.php');
setlocale(LC_ALL, 'nld_nld'); // set local to dutch

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$date = date ('Y-m-d');

// showing the date in dutch
$currentDate = strftime("%A %e %B", mktime(0, 0, 0, date('m'), date('d'),
    date('y')));

// getting the reservations for this week
$weekQuery = "SELECT id,customerid,type_reservation,date,time,car, description
                FROM reservations
                WHERE date
                BETWEEN CAST(timestampadd(SQL_TSI_DAY, -(dayofweek(curdate())-2), curdate()) AS date)
                    and CAST(timestampadd(SQL_TSI_DAY, 5-(dayofweek(curdate())-1), curdate()) AS date)
                    ORDER BY time ASC";
$weekResult = mysqli_query($db, $weekQuery)
    or die('Error '.mysqli_error($db).' with query '. $weekQuery);


$dayQuery = "SELECT id,customerid,type_reservation,date,time,car, description
                                FROM reservations
                                WHERE date = date('Y-m-d')
                                ORDER BY time ASC";
$dayResult = mysqli_query($db, $dayQuery)
    or die('Error '.mysqli_error($db).' with query '. $dayQuery);

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

$times = createArrayWithTimes('09:00', '16:30', 15);

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
    <a href="logout.php">
        <button>Uitloggen</button>
    </a>
</header>

<main>
    <div class="left">
        <h2>Afspraken voor vandaag, <br> <?=$currentDate?></h2>
        <?php foreach ($dayResult as $reservation) { ?>
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
        <h2>Afspraken voor komende week, huidige week: <?=date('W')?></h2>
        <div class="row">
            <?php for($i=0;$i < 7; $i++) { ?>
                <div class="column">
                    <div><?= strftime('%A', strtotime($date ." + $i days"))?></div>
                    <div><?= strftime('%e %B', strtotime($date ." + $i days"))?></div>
                </div>
            <?php } ?>
        </div>

        <?php foreach ($times as $row => $time) { ?>
            <div class="row">
                <?php for($i = -1 ; $i < 7 ; $i++) { ?>

                    <?php if($i == -1) { ?>
                        <div><?= $time ?></div>
                    <?php } else { ?>
                        <div class="column">
                            <?php foreach($reservationsWeek as $reservation) { ?>
                                <?php if(date('N', strtotime($reservation['date'])) == $i && strtotime($time) == strtotime($reservation['time'])) { ?>
                                    <header><?= $reservation['type_reservation'] ?></header>
                                    <div><?= date('H:i',strtotime($reservation['time'])) ?></div>
                                <?php } ?>

                            <?php } ?>

                        </div>
                    <?php } ?>
                <?php } ?>

            </div>
        <?php }  ?>
    </div>
</main>

<footer>

</footer>
</body>
</html>