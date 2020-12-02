<?php
    require_once('../includes/connect.php');

    $indexNumber = $_GET['index'];

    // get the result set from the database with query
    $query = "SELECT * FROM reservations WHERE orderId = $indexNumber";
    $result = mysqli_query($db, $query);

    $reservation = [];
    // loop trough with while
    while($row = mysqli_fetch_assoc($result)) {
        $reservation[$indexNumber] = $row;
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
        </head>

        <body>
            <h1><?php print_r($row['meeting']);?></h1>
            <ul>
                <!-- Name -->
                <li>Naam: <?php print_r($row['name']);?></li>

                <!-- Email -->
                <li>Email adres: <?php print_r($row['email']);?></li>

                <!-- phone number (if it is exists) -->
                <?php if (isset($row['phoneNumber'])) { ?>
                    <li>Telefoonnummer: <?php print_r($row['phoneNumber']);?></li>
                <?php } ?>

                <!-- license plate (if it is exists) -->
                <?php if (isset($row['licensePlate'])) { ?>
                    <li>Kenteken: <?php print_r($row['licensePlate']);?></li>
                <?php } ?>

                <!-- description (if it is exists) -->
                <?php if (isset($row['description'])) { ?>
                    <li>Omschrijving: <?php print_r($row['description']);?></li>
                <?php } ?>

                <!-- car choice (if it is exists) -->
                <?php if (isset($row['carChoice'])) { ?>
                    <li>Keuze auto: <?php print_r($row['carChoice']);?></li>
                <?php } ?>
            </ul>
            <a href="startScreen.php">Terug naar de startpagina</a>
        </body>
    </html>
