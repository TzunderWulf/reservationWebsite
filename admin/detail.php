<?php
session_start();

require_once('../includes/config.php');

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

$query = "SELECT *
        FROM customers
        LEFT JOIN reservations
        ON reservations.customerid = customers.id
            WHERE reservations.id = '$id'";
$customerResult = mysqli_query($db, $query);


$customers = [];
while ($customer = mysqli_fetch_assoc($customerResult)) {
    $customers[] = $customer;
    break;
}

?>

<!doctype html>
<html lang="nl">
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="../css/stylesheet-admin.css">

    <!-- Google Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
</head>

<body class="container">
<header class="item-a">
    <img id="header-img" src="../images/header.png" alt="Garage Nieuw Rijswijk">
</header>

<div class="user">
    <h2>Welkom, <?=$_SESSION['username']?>!</h2>
    <h3><?=date('d-m-Y H:i')?></h3>
    <?php if ($_SESSION['admin'] === 1) { ?>
        <a class="link-button" href="section-user/overview-user.php">Gebruikers</a>
    <?php } ?>
    <a class="link-button" href="">Hulp</a>
    <a class="link-button" href="logout.php">Uitloggen</a>
</div>

<main class="item-c">
    <div id="reservation">
        <h1>Afspraak</h1>
        <h3>Type: <?= $customer['type_reservation'] ?></h3>
        <h3>Datum: <?= date('j-m-Y', strtotime($customer['date'])) ?></h3>
        <h3>Tijd: <?= date('H:i', strtotime($customer['time'])) ?></h3>
    </div>

    <div id="options">
        <a class="link-button" href="">Aanpassen</a>
        <?php if ($_SESSION['admin'] === 1) { ?>
            <a class="link-button" href="">Verwijderen</a>
        <?php } ?>
        <a class="link-button" href="index.php">Terug</a>
    </div>
</main>

<div class="item-b">
    <div id="information">
        <h1>Informatie</h1>
        <!-- license plate (if it is exists) -->
        <?php if (isset($customer['license_plate'])) { ?>
            <h3>Kenteken: <?php print_r(strtoupper($customer['license_plate']));?></h3>
        <?php } ?>
        <?php if (isset($customer['description'])) { ?>
            <h3>Omschrijving: <?php print_r($customer['description']);?></h3>
        <?php } ?>

            <!-- description (if it is exists) -->
        
        <h1>Contact</h1>
        <h3>Naam: <?php print_r($customer['name']);?></h3>
        <h3>E-mailadres: <?php print_r($customer['email']);?></h3>
        <!-- phone number (if it is exists) -->
        <?php if (isset($customer['phonenumber'])) { ?>
            <h3>Telefoonnummer: <?php print_r($customer['phonenumber']);?></h3>
        <?php } ?>

        

        
    </div>
</div>

</body>

<footer class="item-d">
    <p>Aan dit systeem kunnen geen rechten worden voorgeleend. <br> Het systeem is op dit moment nog in de bouw.</p>
</footer>

</html>
