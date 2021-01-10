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
            <label for="naam">Naam*: </label>
            <input type="text" id="naam" name="name"
                   value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
            <p class="error-message"><?= isset($errors['name']) ? $errors['name'] : "" ?></p>
        </div>
        <!-- R: Telefoonnummer van de klant--->
        <div>
            <label for="telefoonnummer">Telefoonnummer: </label>
            <input type="text" id="telefoonnummer" name="phone-number"
                   value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>">
            <p class="error-message"><?= isset($errors['phone-number']) ? $errors['phone-number'] : "" ?></p>
        </div>
        <!-- R: Email van de klant--->
        <div>
            <label for="email-adres">Email*: </label>
            <input type="text" id="email-adres" name="email-address"
                   value="<?=htmlspecialchars($email, ENT_QUOTES);?>">
            <p class="error-message"><?= isset($errors['email']) ? $errors['email'] : "" ?></p>
        </div>
        <!-- R: Kenteken van de auto--->
        <div>
            <label for="kenteken">Kenteken*: </label>
            <input type="text" id="kenteken" name="license-plate"
                   maxlength="8" value="<?=htmlspecialchars($licensePlate, ENT_QUOTES);?>">
            <p class="error-message"><?= isset($errors['license-plate']) ? $errors['license-plate'] : "" ?></p>
        </div>
        <!-- R: Datum mini calender--->
        <div>
            <label for="datum">Datum*: </label>
            <input type="date" id="datum" name="picked-date" min="<?=$currentDate;?>" value="<?=$pickedDate;?>">
            <p class="error-message"><?= isset($errors['picked-date']) ? $errors['picked-date'] : "" ?></p>
        </div>

        <!-- R: Tijd (08:00 tot 18:00) --->
        <div>
            <label for="tijd">Tijd*: </label>
            <input type="time" id="tijd" name="picked-time" min="08:00" max="18:00" step="1800"
                   value="<?=$pickedTime;?>">
            <p class="error-message"><?= isset($errors['picked-time']) ? $errors['picked-time'] : "" ?></p>
        </div>

        <!-- R: Radio button for type of meeting.--->
        <div> <br>
            <div>
            <label for="checkboxes">Kies welke afspraak*</label>
            </div>
            <input type="radio" name="Onderhoud"
                <?php if (isset($keuze) && $keuze=="onderhoud") echo "checked";?>
                   value="onderhoud">Onderhoud <br>
            <input type="radio" name="Reparatie"
                <?php if (isset($keuze) && $keuze=="reparatie") echo "checked";?>
                   value="reparatie">Reparatie <br>
            <input type="radio" name="APK"
                <?php if (isset($keuze) && $keuze=="APK") echo "checked";?>
                   value="APK">APK <br>
            <input type="radio" name="Auto uitleen"
                <?php if (isset($keuze) && $keuze=="Auto Uitleen") echo "checked";?>
                   value="Auto uitleen">Auto Uitleen <br>
        </div>
        <!-- R: omschrijving van de klant--->
        <div><br>
            <label for = "omschrijving" >Omschrijving*: </label><br>
            <textarea id="omschrijving" name="description" rows="4" cols="50"></textarea><br>
            <p class="error"><?= isset($errors['description']) ? $errors['description'] : "" ?></p><br>
        </div>
        <!-- R: bevestiging knop--->
        <div>
            <input type="submit" name="submit" value="Bevestigen">
        </div>

  </main>
 </body>
</html>
