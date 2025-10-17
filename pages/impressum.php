<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="'de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet">
    <title>Datenschutz</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="flex flex-col min-h-screen bg-green-200">

    <header class="fixed w-full flex justify-between items-start">
       <div class="flex gap-x-4 items-center p-4">
            <a href="../pages/home.php" class="flex item-center" title="Book Loving Journal">
                <img class="flex w-20 h-20 rounded-2xl shrink-0" src="../src/img/bj-logo.png" alt="logo">
            </a>
            <h1 class="hidden sm:flex flex-col uppercase w-20 tracking-wide text-2xl leading-none font-bold">
                <a href="../pages/home.php">
                    <span>Book</span>
                    <span>loving</span>
                    <span>journal</span>
                </a>
            </h1>
        </div>

        <!-- logout-button -->
        <div class="flex gap-y-2 items-end flex-col w-60 p-4">
            <?php if (!empty($_SESSION['name'])): ?>
                <p>Eingeloggt als <span class="font-bold"><?= htmlspecialchars($_SESSION['name']); ?></span></p>
                <a href="../php/logout.php"
                    class="logoutBtn justify-self-right bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="pt-38 px-10 pb-20 flex flex-col items-start gap-y-4">
            <h2 class="text-4xl font-semibold py-4">Impressum</h2>
            <h3 class="font-semibold">Allgemeine Angaben</h3>
            <p><b>Internet:</b> <a href="../index.html" target="_blank">www.bookSearch-journal.de</a></p>

            <p><b>Name des Diensteanbieters:</b> myd Einzelunternehmen</p>

            <p><b>Vertreten durch:</b>Maggi Yuen</p>

            <br>
            <h3>Anschrift und Kontakt</h3>
            <p>Steeler Str. 438</p>

            <p>Dachgeschoss</p>

            <p>45138 Essen</p>

            <p><b>Telefon:</b> <a href="tel:015168499912">015168499912</a></p>

            <p><b>Email:</b> <a href="mailto:yuen.maggi@icloud.com">yuen.maggi@icloud.com</a><br><br></p>

            <h3>EU-Streitbeilegungsplattform</h3>
            <p>Wir sind zur Teilnahme an einem Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle nicht
                verpflichtet und nicht bereit.</p>

            <br>
            <h3>Haftung für Inhalte</h3>
            <p>Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und
                Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Wir sind als Diensteanbieter jedoch
                nicht
                verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu
                forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung
                der
                Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche
                Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei
                Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p>

            <br>
            <p class="flex-start text-xs">Erstellt von
                <a href="https://impressum-generator.info/" target="_blank"
                    class="nderlined">impressum-generator.info</a>
            </p>
        </div>
    </main>

    <footer class="flex justify-center w-full">
        <ul class="flex pb-4 pt-40">
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./datenschutz.php">Datenschutz</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./Barrierefreiheit.php">Barrierefreiheit</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="./impressum.php">Impressum</a>
            </li>
        </ul>
    </footer>


    <script>
        // header wird weiß beim vertikalen Scrollen
        const headerStatus = document.querySelector('header');

        function scrollDown() {
            if (window.scrollY > 30) {

                // headerSttus muss das div drüber sein
                headerStatus.style.backgroundColor = "oklch(97% 0.001 106.424)"; // oklich-color
                headerStatus.classList.add('top-0');
                headerStatus.classList.add('h-28');
                headerStatus.classList.add('transition');
                headerStatus.classList.add('duration-500');
                headerStatus.classList.add('opacity-90');
            } else {
                headerStatus.style.backgroundColor = 'transparent';
            }
        }

        window.addEventListener('scroll', scrollDown);

    </script>
</body>

</html>