<!doctype html>
<html lang="nl">

<!-- R: style sheet deed raar bij mij, reageert niet. style update heb ik hier gedaan-->
<style>
    div.a {
        text-align: center;
        font-size: 25px;

    }

    div {
        width: 850px;
        margin: auto;
    }
</style>

    <head>
        <title>Reserveren</title>
        <link rel="stylesheet" href="styles/stylesheet.css">

        <!-- Google Font-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    </head>

    <body>
        <header>
            <img id="header" src="images/header.png" alt="Garage nieuw rijswijk">
        </header>

        <main>
            <section>
                <!-- back to website -->
                <a href="https://garagenieuwrijswijk.nl" class="button2">
                    <button2>Terug naar de website</button2>
                </a>
            </section>

                <!-- introduction -->
            <section>
                <div class="a">
                <h1>Welkom, waarvoor wilt u een afspraak maken?</h1>
                </div>
            </section>

            <section>
                <!-- types of reservations -->
                <div>
                    <h2>Onderhoud</h2>
                    <div>Niets zo vervelend als een auto die je in de steek laat. Daarom is onderhoud heel belangrijk.
                        Je zou kunnen besparen op onderhoud. Maar dat kan leiden tot hogere reparatiekosten en een grotere pechkans.
                        En de veiligheid kan in het geding komen. Een goed onderhouden auto levert bij inruil meer op en is meestal makkelijker te verkopen.
                        Sommige dingen kun je zelf, andere werkzaamheden kun je beter aan de garage overlaten.</div>

                    <a href="reservation/maintenance.php">
                        <br> <button>Maak een afspraak</button>
                    </a>
                </div>

                <div>
                    <h2>Reperatie en schadeherstel</h2>
                     <div>Zoekt u een betrouwbare partner voor uw auto? Ons garagebedrijf helpt u met allerhande reparaties aan uw auto.
                        Wij beschikken over professionele uitlees apparatuur zodat wij de diagnosegegevens van nagenoeg alle merken direct kunnen uitlezen.
                         Zo is het voor ons mogelijk om snel problemen met uw auto op te sporen</div>
                   <a href="reservation/repair.php">
                        <br> <button>Maak een afspraak</button>
                    </a>
                </div>

                <div>
                    <h2>APK</h2>
                    <div>Is uw auto toe aan de Algemeen Periodieke Keuring? (APK).
                        Breng uw auto dan snel langs bij Garage nieuw rijswijk of maak tijdig een afspraak. Voorkom onnodige boetes!
                        U kunt al bij ons terecht voor een APK vanaf € 30,50-! </div>
                    <a href="reservation/apk.php">
                        <br> <button>Maak een afspraak</button>
                    </a>
                </div>
            </section>
        </main>

        <!--
        <footer>
            <p>Made with the power of PHP</p>
        </footer>
        -->
    </body>
</html>