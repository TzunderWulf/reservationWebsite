<?php
//Values
$name = $phoneNumber = $email = $licensePlate = $pickedDate = $pickedTime = $description = $typeReservation = "";
$errors = [];

if (isset($_POST['submit'])){
    $validForm = true;
    //R: checks if name field isn't empty
    if (empty($_POST['name'])){
        $validForm = false;
        $errors['name'] = "Dit veld moet ingevuld worden.";
    }else{
        $name = htmlspecialchars($_POST['name']); // name is valid
    }

    //R: checks if phonenumber field isn't empty
    if ($_POST['phone-number']) {
        //R: Phone number check
        if (!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/",
            $_POST['phone-number'])) {
            $errors['phone-number'] = "Dit veld is verkeerd ingevuld.";
        } else {
            $phoneNumber = htmlspecialchars($_POST['phone-number']); // phone number is valid
        }
    }

    //R: checks if email field isn't empty
    if (empty($_POST['email-address'])) {
        $errors['email'] = "E-mail is niet ingevuld.";
    } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veld is verkeerd ingevuld.";
    } else {
        $email = htmlspecialchars($_POST['email-address']); // email address is valid
    }

    //R: checks if license plate field isn't empty
    if (empty($_POST['license-plate'])) {
           $licenseplate = new \Intrepidity\LicensePlate\DutchLicensePlate($_POST['license-plate']);
        if (empty($_POST['license-plate'])) {
            $errors['license-plate'] = "Veld moet ingevuld worden";
        } elseif ($licenseplate->isValid()) {
            $licensePlate = htmlspecialchars(strtoupper($_POST['license-plate'])); // license plate is valid
        } else {
            $errors['license-plate'] = "Veld is vekeerd ingevuld";
        }
    }
    //R: checks if empty and if it time isn't before 08:00 or after 18:00
    if (empty($_POST['picked-time'])) {
        $errors['picked-time'] = "";
    } elseif (date('G', strtotime($_POST['picked-time'])) < 8 || date('G', strtotime($_POST['picked-time'])) >= 18) {
        $errors['picked-time'] = "Kies een tijd";
    } else {
        $pickedTime = htmlspecialchars($_POST['picked-time']);
    }

    //R: checks if description isn't empty
    if (empty($_POST['description'])){
        $validForm = false;
        $errors['name'] = "Dit veld moet ingevuld worden.";
    }else{
        $name = htmlspecialchars($_POST['name']); // name is valid
    }
    $typeReservation = $_POST['type-reservation'];

}
$currentDate = date('Y-m-d', strtotime("+1 day")); // Var for the current date + 1 day
?>
<!-- Update! R: alle <br> zij verwijderd--->
<!doctype html>
<html lang="nl">
<head>
    <title>Form pagina</title>
    <link rel="stylesheet" href="../styles/stylesheet.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
</head>

<body>
<main>
    <form action="" method="post">
        <div>
            <!-- R: Naam van de klant--->
            <label for="name">Naam*: </label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($name, ENT_QUOTES) ?>">
            <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p>
        </div>
        <!-- R: Telefoonnummer van de klant--->
        <div>
            <label for="phone-number">Telefoonnummer: </label>
            <input type="text" id="phone-number" name="phone-number"
                   value="<?= htmlspecialchars($phoneNumber, ENT_QUOTES) ?>">
            <p class="error-message"><?= isset($errors['phone-number']) ? $errors['phone-number'] : "" ?></p>
        </div>
        <!-- R: Email van de klant--->
        <div>
            <label for="email-address">Email*: </label>
            <input type="text" id="email-address" name="email-address"
                   value="<?= htmlspecialchars($email, ENT_QUOTES) ?>">
            <p class="error-message"><?= isset($errors['email']) ? $errors['email'] : "" ?></p>
        </div>
        <!-- R: Kenteken van de auto--->
        <div>
            <label for="license-plate">Kenteken*: </label>
            <input type="text" id="license-plate" name="license-plate"
                   maxlength="8" value="<?= htmlspecialchars($licensePlate, ENT_QUOTES) ?>">
            <p class="error-message"><?= isset($errors['license-plate']) ? $errors['license-plate'] : "" ?></p>
        </div>
        <!-- R: Datum mini calender--->
        <div>
            <label for="picked-date">Datum*: </label>
            <input type="date" id="picked-date" name="picked-date" min="<?= $currentDate ?>" value="<?= $pickedDate ?>">
            <p class="error-message"><?= isset($errors['picked-date']) ? $errors['picked-date'] : "" ?></p>
        </div>

        <!-- R: Tijd (08:00 tot 18:00) --->
        <div>
            <label for="picked-time">Tijd*: </label>
            <input type="time" id="picked-time" name="picked-time" min="08:00" max="18:00" step="1800"
                   value="<?= $pickedTime ?>">
            <p class="error-message"><?= isset($errors['picked-time']) ? $errors['picked-time'] : "" ?></p>
        </div>

        <!-- R: Radio button for type of meeting.--->
        <!-- Update! R: Checkbox staat nu in header 3 en radioboxes zijn ge-updated via feedback info--->
        <div>
            <h3>Checkboxes</h3>
            <div>
            <label for="maintenance">Onderhoud</label>
            <input type="radio" id="maintenance" name="type-reservation" value="onderhoud">
                <?php if (isset($keuze) && $keuze=="onderhoud") {echo "checked";}?>

            <label for="repair">reparatie</label>
            <input type="radio" id="repair" name="type-reservation" value="reperatie">
                <?php if (isset($keuze) && $keuze=="reparatie"){echo "checked";}?>

            <label for="apk">APK</label>
            <input type="radio" id="apk" name="type-reservation" value="apk">
                <?php if (isset($keuze) && $keuze=="APK") {echo "checked";}?>
            </div>
        </div>

        <!-- R: omschrijving van de klant--->
        <div>
            <label for = "omschrijving" >Omschrijving*: </label><br>
            <textarea id="omschrijving" name="description" rows="4" cols="50"></textarea><br>
            <p class="error"><?= isset($errors['description']) ? $errors['description'] : "" ?></p>
        </div>
        <!-- R: bevestiging knop--->
        <div>
            <input type="submit" name="submit" value="Bevestigen">
        </div>

  </main>
 </body>
</html>
