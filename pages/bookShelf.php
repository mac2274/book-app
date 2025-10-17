<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Bücherregal</title>
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
            <p class="">Eingeloggt als <span class="font-bold"><?php echo $_SESSION['name']; ?></span></p>

            <a href="../php/logout.php"
                class="logoutBtn justify-self-right bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>

    <main class="flex flex-grow justify-center flex-col">
        <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4">
            <h2 class="text-4xl text-center font-semibold py-4">Dein Bücherregal</h2>
            <div class="flex flex-row gap-2 flex-wrap justify-center">
                <a href="../php/showFavs.php"
                    class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                    Favouriten
                </a>
                <a href="../php/showDoneReading.php"
                    class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                    Bereits gelesene Bücher
                </a>

                <a href="../php/ShowToBeRead.php"
                    class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                    Noch zu lesene Bücher
                </a>
            </div>
        </div>

        <!-- ----------------------- zurück-button  -->
        <div class="flex w-full justify-end">
            <a href="../pages/home.php"
                class="backButton fixed bottom-10 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
                zurück</a>
        </div>
    </main>

    <footer class="flex justify-center items-end pb-4">
        <ul class="flex">
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
        window.addEventListener('scroll', (event) => {
            if (window.screenY > 10) {
                let backButton = event.target.closest('.backButton');
                backButton.style.display = 'flex';
            }
        })

    </script>
</body>

</html>