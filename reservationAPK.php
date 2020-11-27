<?php
    $placeholder = "placeholder";
?>
<html>
    <head lang="nl">
        <title>Reserveren APK</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>
        <h2>Afspraak maken voor APK</h2>
        <h3>* is verplicht</h3>

        <form action="<?= $placeholder ?>" method="post">
            <label for="voornaam">Voornaam*: </label>
            <input type="text" id="voornaam" name="firstName">
            <p><?= $placeholder ?></p><br>

            <label for="achternaam">Achternaam*: </label>
            <input type="text" id="achternaam" name="lastName"><br>
            <p><?= $placeholder ?></p><br>

            <label for="kenteken">Kenteken*: </label>
            <input type="text" id="kenteken" name="licensePlate" placeholder="AB-32H-K"><br>
            <p><?= $placeholder ?></p><br>

            <input type="submit" name="submit" value="submit">
        </form>
    </body>
</html>
