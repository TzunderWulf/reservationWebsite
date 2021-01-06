//form
<?php
//Values
$name = $phoneNumber = $email = $licensePlate = $description = $pickedDate = $pickedTime = $typeReservation = "";
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

    if ($_POST['phone-number']) {
        //R: Phone number check
        if (!preg_match("/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/",
            $_POST['phone-number'])) {
            $errors['phone-number'] = "Dit veld is verkeerd ingevuld.";
        } else {
            $phoneNumber = htmlspecialchars($_POST['phone-number']); // phone number is valid
        }
    }

    if (empty($_POST['email-address'])) {
        $errors['email'] = "E-mail is niet ingevuld.";
    } elseif (!filter_var($_POST['email-address'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veld is verkeerd ingevuld.";
    } else {
        $email = htmlspecialchars($_POST['email-address']); // email address is valid
    }


}


