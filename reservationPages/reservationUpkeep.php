<?php
// S: ik heb overal $_POST['key'] aangepast zodat 'key' overeenkomt met de name value
// van de inputs (hoofdlettergevoelig btw)

#variabelen
$naam = '';
$telefoonnummer = '';
$email = '';
$kenteken= '';
$omschrijvingOnderhoud = '';

// Error variabelen
$naamErr = '';
$emailErr = '';
$kentekenErr = '';
$omschrijvingOnderhoudErr = '';

if (isset($_POST['submit'])) {
    $validForm = true; // boolean dat checked of iets leeg is of niet

    // validatie van gegevens
    if (!isset($_POST['naam']) || $_POST['naam'] === '') {
        $validForm = false;
        $naamErr = 'Dit veld is verplicht.';
    } else {
        $naam = htmlspecialchars($_POST['naam']);
    }
    // validatie voor email
    if (!isset($_POST['email']) || $_POST['email'] === '') {
        $validForm = false;
        $emailErr = 'Dit veld is verplicht.';
    } else {
        $email = htmlspecialchars($_POST['email']);
    }
    // validatie voor kenteken
    if (!isset($_POST['kenteken']) || $_POST['kenteken'] === '') {
        $validForm = false;
        $kentekenErr = 'Dit veld is verplicht.';
        // S: was $kenteken, moest $kentekenErr
    } else {
        $kenteken = htmlspecialchars($_POST['kenteken']);
    }
    // validatie voor onderhoud
    if (!isset($_POST['omschrijvingOnderhoud']) || $_POST['omschrijvingOnderhoud'] === '') {
        $validForm = false;
        $omschrijvingOnderhoudErr = 'Dit veld is verplicht.';
        // S: was $omschrijvingOnderhoud, moest $omschrijvingOnderhoudErr
    } else {
        $omschrijvingOnderhoud = htmlspecialchars($_POST['omschrijvingOnderhoud']);
    }
    //Telefoonummer
    $telefoonnummer = $_POST['telefoonnummer']; // S: was $_POST['telefoonNummer'] moest _POST['telefoonnummer'] zijn
    // (overeenkomen met name van input)

    // if the entire form is valid sent user to confirmation page
    if ($validForm) {
        header('Location: ../confirmation.php');
    }
}
?>

<!doctype html>
<html lang="nl">
<head>
    <title>Afspraak voor auto reparatie en schadeherstelling</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>

<body>
<a href="../index.php">Terug</a>
<h1>Afspraak maken voor auto reparatie en autoschade </h1>
<h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

<form action="" method="post">
    <!-- input voor naam !-->
    <label for="naam">Naam*: </label>
    <input type="text" id="naam" name="naam" value="<?=htmlspecialchars($naam, ENT_QUOTES);?>">
    <p class="error"><?=$naamErr;?></p><br>

    <!-- input voor telefoon nummer !-->
    <label for="telefoonnummer">Telefoonnummer: </label>
    <input type="text" id="telefoonnummer" name="telefoonnummer" maxlength="11" placeholder="06-12345678"
        value="<?=htmlspecialchars($telefoonnummer, ENT_QUOTES);?>"><br>

    <!-- input voor email address !-->
    <label for="email">Emailadres*: </label>
    <input type="email" id="email" name="email" placeholder="example@example.nl" value="<?=
    htmlspecialchars($email, ENT_QUOTES);?>">
    <p class="error"><?=$emailErr;?></p><br>

    <!-- input voor kenteken !-->
    <label for="kenteken">Kenteken*: </label>
    <input type="text" id="kenteken" name="kenteken" maxlength="8" placeholder="AB-C3D-5" value="<?=
    htmlspecialchars($kenteken, ENT_QUOTES);
    ?>">
    <p class="error"><?=$kentekenErr;?></p><br>

    <!-- Hiervoor kijken naar textarea's !-->
    <!-- https://www.w3schools.com/tags/tag_textarea.asp en het stylen: https://www.w3schools.com/css/css_form.asp !-->
    <!-- input voor Omschrijving type onderhoudt !-->
    <label for = "omschrijving onderhoud" >Omschrijving wat voor type onderhoud</label>
    <input type="text" id="omschrijving onderhoud" name="omschrijvingOnderhoud" maxlength="1000" placeholder="Voer hierin wat uw problemen zijn met u auto..." value="<?=
    htmlspecialchars($omschrijvingOnderhoud, ENT_QUOTES);
    ?>">
    <p class="error"><?=$omschrijvingOnderhoudErr;?></p><br>

    <h3>Kies hieronder een datum voor de resevering.</h3>

    <!-- agenda!-->

    <!-- Reset knop van Sara-->
    <!-- Form validatie fout? Wordt gegeven-->
    <input type="reset" name="reset" value="Reset">
    <input type="submit" name="submit" value="Bevestigen">
</form>
</body>
</html>