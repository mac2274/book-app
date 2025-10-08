<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Bücherregal</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="relative flex flex-col items-center justify-center gap-y-10 h-screen bg-green-200 p-4">
    <header class="absolute top-4 left-4 flex w-40 gap-x-4 items-center">
        <img class="flex w-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">

        <h1 class="flex flex-col uppercase tracking-wide text-2xl leading-none font-bold">
            <a href="../pages/home.php">
                <span>Book</span>
                <span>loving</span>
                <span>journal</span>
            </a>
        </h1>

        <!-- logout-button -->
        <div class="fixed top-4 right-4 flex flex-col items-center">
            <p class="mb-2">Eingeloggt als
                <span class="font-bold">
                    <?php echo $_SESSION['name']; ?>
                </span>
            </p>

            <a href="../php/logout.php"
                class="logoutBtn justify-self-right bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>

    <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4">
        <h2 class="text-4xl font-semibold mt-4">Dein Bücherregal</h2>
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
            class="backButton fixed bottom-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
            zurück</a>
    </div>