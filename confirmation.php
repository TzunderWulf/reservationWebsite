<?php

?>

<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Afspraak maken</title>
    </head>
    <body>
        <h1>Afspraak bevestigd</h1>
        <h3>Er is een afspraak gemaakt voor [afspraak] op [date]</h3>
        <h3>De volgende informatie is doorgegeven: </h3>
        <ul>
            <li>Naam: <?php echo $_POST['Voornaam'] . " " . $_POST['Voornaam'];?></li>
            <li>Telefoonnummer: <?php echo $_POST['Telefoonnummer'];?></li>
            <li>Emailadres: <?php echo $_POST['Email'];?></li>
            <li>Kenteken: <?php echo $_POST['Kenteken'];?></li>
            <li>Werkzaamheden: <?php echo $_POST['Werkzaamheden'];?></li>
        </ul>
    </body>
</html>
