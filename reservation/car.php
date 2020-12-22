<?php
require_once('../includes/config.php'); // To connect to database
require('../includes/validation-reservervation.php'); // To validate form

$typeReservation = "Auto uitleen"; // Var for type reservation
$currentDate = date('Y-m-d', strtotime("+1 day")); // Var for the current date + 1 day
?>

<!doctype html>
    <html lang="nl">
        <head>
            <title>Reserveren auto</title>
            <link rel="stylesheet" href="../styles/stylesheet.css">

            <!-- Google Font-->
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
        </head>

        <body>
            <header>
                <img id="header" src="../images/header.png"
                     alt="Garage nieuw rijswijk">
            </header>

            <main>
                <a href="../index.php">
                    <button>Terug</button>
                </a>

                <div>
                    <h1>Afspraak maken voor het lenen van een auto</h1>
                    <h3>Vul hieronder de gegevens in het formulier, de gegevens met * zijn verplicht.</h3>
                </div>

                <form action="" method="post">
                    <!-- Inputs for user data that is needed for reservation -->
                    <!-- input for name !-->
                    <div>
                        <label for="naam">Naam*: </label>
                        <input type="text" id="naam" name="name"
                               value="<?=htmlspecialchars($name, ENT_QUOTES);?>">
                        <p class="error-message"><?=$nameErr;?></p>
                    </div>

                    <!-- Input for phone number -->
                    <div>
                        <label for="telefoonnummer">Telefoonnummer: </label>
                        <input type="text" id="telefoonnummer" name="phone-number"
                               value="<?=htmlspecialchars($phoneNumber, ENT_QUOTES);?>">
                        <p class="error-message"><?=$phoneErr;?></p>
                    </div>

                    <!-- Input for email address, required -->
                    <div>
                        <label for="email-adres">Email*: </label>
                        <input type="text" id="email-adres" name="email-address"
                               value="<?=htmlspecialchars($email, ENT_QUOTES);?>">
                        <p class="error-message"><?=$emailErr;?></p>
                    </div>

                    <!-- Input for picking a car, required -->
                    <div>
                        <label for="auto-keuze">Kies een van de twee auto's*: </label>
                        <input type="radio" id="auto-keuze" name="picked-car" value="1"<?php
                        if ($pickedCar == '1') {
                            echo ' checked';
                        }?>>Auto 1
                        <input type="radio" id="auto-keuze" name="picked-car" value="2"<?php
                            if ($pickedCar == '2') {
                                echo ' checked';
                            }?>>Auto 2
                        <p class="error-message"><?=$pickedCarErr;?></p>
                    </div>

                    <h3>Selecteer hieronder de periode dat u de auto wilt lenen.</h3>

                        <!-- agenda with possible times !-->

                    <div>
                        <input type="hidden" name="type-reservation" value="car">
                    </div>

                    <div>
                        <input type="submit" name="submit" value="Bevestigen">
                    </div>
                </form>
            </main>

            <!--
            <footer>
                <p>Made with the power of PHP</p>
            </footer>
            -->
        </body>
    </html>
