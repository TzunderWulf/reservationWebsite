<?php
    require_once('../includes/connect.php');

    // get the result set from the database with query
    $queryRepair = "SELECT orderId,name,phoneNumber,email,licensePlate,description FROM reservations WHERE meeting = 'Onderhoud'";
    $resultRepair = mysqli_query($db, $queryRepair);

    $reservationsMain = [];
    // loop trough with while
    while($row = mysqli_fetch_assoc($resultRepair)) {
        $reservationsMain[] = $row;
        break;
    }

    $queryAPK = "SELECT orderId,name,phoneNumber,email,licensePlate FROM reservations WHERE meeting = 'APK'";
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

    <h3>Alle onderhoud afspraken</h3>
    <table>
        <thead>
        <tr>
            <th>order id*</th>
            <th>naam*</th>
            <th>telefoonnummer</th>
            <th>email*</th>
            <th>kenteken</th>
            <th>beschrijving</th>
            <th><?php if (isset ($row['carChoice'])) {?>auto keuze<?php } ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resultRepair as $row) { ?>
            <tr>
                <td><?php print_r($row['orderId']);?></td>
                <td><?php print_r($row['name']);?></td>
                <td><?php print_r($row['phoneNumber']);?></td>
                <td><?php print_r($row['email']);?></td>
                <td><?php print_r(strtoupper($row['licensePlate']));?></td>
                <td><?php print_r($row['description']);?></td>
                <td><a href="detail.php?index=<?=$row['orderId']?>">Details</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <h3>Alle APK afspraken</h3>
    <table>
        <thead>
        <tr>
            <th>order id*</th>
            <th>naam*</th>
            <th>telefoonnummer</th>
            <th>email*</th>
            <th>kenteken</th>
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
                <td><a href="detail.php?index=<?=$row['orderId']?>">Details</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>

