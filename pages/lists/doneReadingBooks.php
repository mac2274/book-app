<?php
require_once '../../config/lib.php';
//require_once '../../config/saveDoneReading.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Bereits gelesene Bücher</title>
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

    <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4 my-80 mt-150 h-full">
        <h2 class="text-4xl font-semibold mt-4">Deine bereits gelesenen Bücher</h2>
        <ol class="doneReadingBooks list-decimal list-outside w-xl px-8">
            <?php showDoneReading() ?>
        </ol>

        <button
            class="showMore mb-10 border-teal-600 border-2 text-teal-600 rounded-4xl p-2 hover:bg-teal-600 hover:text-white hover:transition duration-500">
            mehr anzeigen
        </button>
    </div>



    <!-- ----------------------- zurück-button  -->
    <div class="flex w-full justify-end">
        <a href="../../pages/bookShelf.html"
            class="backButton fixed bottom-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
            zurück</a>
    </div>

    <script>
        const doneContainer = document.querySelector('.doneReadingBooks');
        const btnShowMore = document.querySelector('.showMore');
        
        let limit = 10;
        let offset = 0;

        async function showMoreBooks() {
            //const url = "saveDoneReading.php";
            try {
                const response = await fetch(`../../php/getDoneReading.php?limit=${limit}&offset=${offset}`); // Verwenden der php-Datei!
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const books = await response.json();
                console.log(books);

                books.forEach(book => {
                    const li = document.createElement('li');
                    li.innerHTML = `<span>${book['title']}</span>`;
                    doneContainer.appendChild(li);
                });

                offset += limit;

            } catch (error) {
                console.error(error.message);
            }
        }

        btnShowMore.addEventListener('click', showMoreBooks);
    </script>