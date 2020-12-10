<?php
    session_start();

    if(isset($_SESSION['pickedDate']) && isset($_SESSION['pickedTime'])) {
        // do nothing
    } else {
        header('Location: index.php');
    }
?>

<!doctype html>
<html lang="nl">
    <head>
        <title>Bevestiging</title>
        <link rel="stylesheet" href="styles/stylesheet.css">

        <!-- Google Font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    </head>

    <body>
        <header>
            <img id="header" src="https://garagenieuwrijswijk.nl/wp-content/uploads/2014/01/cropped-header45.png"
                 alt="Garage nieuw rijswijk">
        </header>

        <main>
            <section>
                <h1 class="confirmation">Reservering geslaagd!</h1>
                <h3 class="confirmation">Bij deze heeft u een reservering gemaakt op <?=$_SESSION['pickedDate'];?> om
                    <?=$_SESSION['pickedTime'];?></h3>
                <img src="" alt="bevestiging">
                <h3 class="confirmation">U ontvangt ook een bevestigingsmail binnenkort.</h3>
            </section>

            <a href="https://garagenieuwrijswijk.nl" onclick="<?php session_unset(); session_destroy();?>">
                <button>Terug naar de website</button>
            </a>
        </main>

        <footer>

        </footer>
    </body>


</html>
