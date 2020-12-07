<?php
    require_once('../includes/connect.php');
    $currentDate = date('j F'); // to see what the current date is
    $currentWeek = date('W'); // to see what the current week is

    // get the result set from the database with query
    $queryToday = "SELECT orderId,name,phoneNumber,email,licensePlate,description,dateReservation FROM reservations WHERE dateReservation = '$currentDate'";
    $resultToday = mysqli_query($db, $queryToday);

    $reservationsMain = [];
    // loop trough with while
    while($row = mysqli_fetch_assoc($resultToday)) {
        $reservationsMain[] = $row;
        break;
    }

    $queryAPK = "SELECT orderId,name,phoneNumber,email,licensePlate,dateReservation 
    FROM reservations 
    WHERE dateReservation   
    BETWEEN CAST(timestampadd(SQL_TSI_DAY, -(dayofweek(curdate())-2), curdate()) AS date) 
        and CAST(timestampadd(SQL_TSI_DAY, 5-(dayofweek(curdate())-1), curdate()) AS date)";
    $resultAPK = mysqli_query($db, $queryAPK);

    $reservationsAPK = [];

    // loop trough with while
    while($row = mysqli_fetch_assoc($resultAPK)) {
        $reservationsAPK[] = $row;
        break;
    }
    // close connection
    $db->close();
?>

<!doctype html>
<html lang="nl">
<head>
    <title>Homescreen</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Welkom!</h1>
    <a href="login.php">Uitloggen</a>
    <h2>Alle afspraken voor vandaag <?=$currentDate?></h2>
    <table>
        <thead>
        <tr>
            <th>order id*</th>
            <th>naam*</th>
            <th>telefoonnummer</th>
            <th>email*</th>
            <th>kenteken</th>
            <th>beschrijving</th>
            <th>afspraak</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resultToday as $row) { ?>
            <tr>
                <td><?php print_r($row['orderId']);?></td>
                <td><?php print_r($row['name']);?></td>
                <td><?php print_r($row['phoneNumber']);?></td>
                <td><?php print_r($row['email']);?></td>
                <td><?php print_r(strtoupper($row['licensePlate']));?></td>
                <td><?php print_r($row['description']);?></td>
                <td><?php print_r($row['dateReservation']);?></td>
                <td><a href="detail.php?index=<?=$row['orderId']?>">Details</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <h2>Alle afspraken voor deze week <?=$currentWeek?></h2>
    <table>
        <thead>
        <tr>
            <th>order id*</th>
            <th>naam*</th>
            <th>telefoonnummer</th>
            <th>email*</th>
            <th>kenteken</th>
            <th>afspraak</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resultAPK as $row) { ?>
            <tr>
                <td><?php print_r($row['orderId']);?></td>
                <td><?php print_r($row['name']);?></td>
                <td><?php print_r($row['phoneNumber']);?></td>
                <td><?php print_r($row['email']);?></td>
                <td><?php print_r(strtoupper($row['licensePlate']));?></td>
                <td><?php print_r($row['dateReservation']);?></td>
                <td><a href="detail.php?index=<?=$row['orderId']?>">Details</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>

