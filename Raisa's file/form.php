//form
<?php
//Values
$name = $phoneNumber = $email = $licensePlate = $description = $pickedDate = $pickedTime = $typeReservation = $phoneNumber = "";
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
}
