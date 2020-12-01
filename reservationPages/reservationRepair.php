<?php
#R: Heb alle $ een engelse naam gegeven
// variabelen
$name = '';
$phoneNumber = '';
$email = '';
$licensePlate= '';
$descRepairation = '';

// Error variabelen
$nameErr = '';
$emailErr = '';
$licensePlateErr = '';
$descRepairationErr  = '';

if (isset($_POST['submit'])) {
    $validForm = true;

    // validatie van gegevens
    if (!isset($_POST['name']) || $_POST['name'] === '') {
        $validForm = false;
        $nameErr = 'Dit veld is verplicht.';
    } else {
        $name = htmlspecialchars($_POST['name']);
    }
    // validatie voor email
    if (!isset($_POST['email']) || $_POST['email'] === '') {
        $validForm = false;
        $emailErr = 'Dit veld is verplicht.';
    } else {
        $email = htmlspecialchars($_POST['email']);
    }
    // validatie voor kenteken
    if (!isset($_POST['licensePlate']) || $_POST['licensePlate'] === '') {
        $validForm = false;
        $licensePlateErr = 'Dit veld is verplicht.'; // S: was $kenteken, moest $kentekenErr
    } else {
        $licensePlate = htmlspecialchars($_POST['licensePlate']);
    }
    // validatie voor reparatie
    if (!isset($_POST['descRepairation']) || $_POST['descRepairation'] === '') {
        $validForm = false;
        $descRepairationErr= 'Dit veld is verplicht.';
    } else {
        $descRepairation = htmlspecialchars($_POST['descRepairation']);
    }
    //Telefoonummer
    $phoneNumber = $_POST['phoneNumber'];

    // if the entire form is valid sent user to confirmation page
    if ($validForm) {
        header('Location: ../confirmation.php');
    }
}
?>

<!doctype html>
<html lang="nl">
<head>
    <title>Afspraak voor auto onderhoud</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>

<body>
<a href="../index.php">Terug</a>
<h1>Afspraak maken voor auto onderhoud?</h1>
<h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>

<form action="" method="post">
    <!-- input voor naam !-->
    <label for="name">Naam*: </label>
    <input type="text" id="name" name="name" value="<?=htmlspecialchars($name, ENT_QUOTES);?>">

    <p class="error"><?=$nameErr;?></p><br>

    <!-- input voor telefoon nummer !-->
    <label for="phoneNumber">Telefoonnummer: </label>
    <input type="text" id="phoneNumber" name="phoneNumber" maxlength="11" placeholder="06-12345678"
           value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>"><br>
    <br>

    <!-- input voor email address !-->
    <label for="email">Emailadres*: </label>
    <input type="email" id="email" name="email" placeholder="example@example.nl" value="<?=
    htmlspecialchars($email, ENT_QUOTES);?>">
    <p class="error"><?=$emailErr;?></p><br>

    <!-- input voor kenteken !-->
    <label for="licensePlate">Kenteken*: </label>
    <input type="text" id="licensePlate" name="licensePlate" maxlength="8" placeholder="AB-C3D-5" value="<?=
    htmlspecialchars($licensePlate, ENT_QUOTES);
    ?>">
    <p class="error"><?=$licensePlateErr;?></p><br>

    <!-- input voor omschrijving reparatie of herstel !-->
    <!-- R: heb descRepairation in plaats van textInput een textArea gemaakt-->
    <label for = "descRepairation" >Omschrijving wat er gerepareerd of hersteld moet worden*</label><br>
    <label> <textarea id="descRepairation" name="descRepairation" rows="4" cols="50"  value=" <?= htmlspecialchars($descRepairation, ENT_QUOTES); ?>"></textarea> </label><br>
    <p class="error"><?=$descRepairation;?></p><br>

    <h3>Kies hieronder een datum voor de resevering.</h3>

    <!-- agenda!-->
    <!-- Reset knop van Sara-->
    <!-- Form validatie fout? Wordt gegeven-->
    <input type="reset" name="reset" value="Reset">
    <input type="submit" name="submit" value="Bevestigen">
</form>
</body>
</html