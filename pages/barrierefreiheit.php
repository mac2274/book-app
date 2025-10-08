<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="'de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Datenschutz</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="relative flex flex-col items-center justify-center gap-y-10 h-screen bg-green-200 p-4">
    <header class="fixed top-0 p-4 w-full">
        <div class="absolute flex w-40 gap-x-4 items-center">
            <img class="flex w-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">

            <h1 class="flex flex-col uppercase tracking-wide text-2xl leading-none font-bold">
                <a href="./home.php">
                    <span>Book</span>
                    <span>loving</span>
                    <span>journal</span>
                </a>
            </h1>

            <!-- logout-button -->
            <div class="fixed top-4 right-4 flex flex-col items-center">
                <p class="mb-2">Eingeloggt als <span class="font-bold"><?php echo $_SESSION['name']; ?></span></p>

                <a href="../php/logout.php"
                    class="logoutBtn justify-self-right bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
            </div>
        </div>
    </header>

    <div id="searchDiv" class="absolute top-38 px-10 pb-20 flex flex-col items-start gap-y-4">
        <h2 class="text-4xl font-semibold mt-4">Barrierefreiheit</h2>



        <footer class="absolute bottom-4 w-full">
            <ul class="flex justify-center gap-x-2">
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
    </div>


    <script>
        // header wird weiß beim vertikalen Scrollen
        const headerStatus = document.querySelector('header');

        function scrollDown() {
            if (window.scrollY > 50) {

                // headerSttus muss das div drüber sein
                headerStatus.classList.add('bg-white');
                headerStatus.classList.add('top-0');
                headerStatus.classList.add('h-28');
                headerStatus.classList.add('transition');
                headerStatus.classList.add('duration-500');
                headerStatus.classList.add('z-10000');
                headerStatus.classList.add('opacity-90');
            } else {
                headerStatus.classList.remove('bg-white');
            }
        }

        window.addEventListener('scroll', scrollDown);

    </script>