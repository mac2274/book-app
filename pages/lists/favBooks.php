<?php
require_once '../../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Favouriten</title>
    <link rel="icon" type="image/x-icon" href="../../src/img/bj-logo.png">
</head>

<body class="relative flex flex-col items-center justify-center gap-y-10 h-screen bg-green-200 p-4">
    <header class="absolute top-4 left-4 flex w-40 gap-x-4 items-center">
        <img class="flex w-20 rounded-2xl" src="../../src/img/bj-logo.png" alt="logo">

        <h1 class="flex flex-col uppercase tracking-wide text-2xl leading-none font-bold">
            <a href="../../index.html">
                <span>Book</span>
                <span>loving</span>
                <span>journal</span>
            </a>
        </h1>
        </a>
    </header>

    <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4 mt-80 h-full">
        <h2 class="text-4xl font-semibold mt-4">Deine Favouriten</h2>
        <ol class="favList list-decimal list-outside w-xl px-8">
            <?php showFavs() ?>
        </ol>
    </div>

    <!-- ----------------------- zurück-button  -->
    <div class="flex w-full justify-end">
        <a href="../../pages/loginUser.php"
            class="backButton fixed bottom-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
            zurück</a>
    </div>

    <script>
        document.querySelectorAll(".reveal_more").forEach(button => {
            button.addEventListener("click", () => {
                let revealDescript = document.querySelector('.revealDiv');

                if (revealDescript) {
                    revealDescript.remove();
                } else {
                    revealDescript = document.createElement("div");
                    let descript = button.dataset.desc; // holt die Beschreibung
                    revealDescript.textContent = descript;
                    revealDescript.className = "revealDiv pt-4 text-sm";
                    button.parentElement.appendChild(revealDescript);
                }
            });
        });
    </script>