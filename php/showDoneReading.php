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

    <title>Bereits gelesene Bücher</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="relative flex flex-col items-center justify-center gap-y-10 h-screen bg-green-200 p-4">
    <header class="fixed top-0 p-4 w-full">
        <div class="absolute flex w-40 gap-x-4 items-center">
            <img class="flex w-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">

            <h1 class="flex flex-col uppercase tracking-wide text-2xl leading-none font-bold">
                <a href="../index.html">
                    <span>Book</span>
                    <span>loving</span>
                    <span>journal</span>
                </a>
            </h1>

            <!-- logout-button -->
            <a href="../php/logout.php"
                class="logoutBtn fixed top-4 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>

    <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4 my-80 h-full">
        <h2 class="text-4xl font-semibold mt-4">Deine bereits gelesenen Bücher</h2>
        <ol class="doneReadingList list-decimal list-outside w-xl px-8">
            <?php showDoneReading() ?>
        </ol>

        <!-- ------------------ Button für weitere Bücher -->
        <button
            class="showMore mb-10 border-teal-600 border-2 text-teal-600 rounded-4xl p-2 hover:bg-teal-600 hover:text-white hover:transition duration-500">
            mehr anzeigen
        </button>
    </div>

    <!-- ----------------------- zurück-button  ------------->
    <div class="flex w-full justify-end">
        <a href="../pages/bookShelf.html"
            class="backButton fixed bottom-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
            zurück</a>
    </div>

    <script>
        const headerStatus = document.querySelector('header');
        const doneContainer = document.querySelector('.doneReadingList');
        const btnShowMore = document.querySelector('.showMore');

        let limit = 10;
        let offset = 10;

        // header wird weiß beim vertikalen Scrollen
        function scrollDown() {
            if (window.scrollY > 50) {

                // headerSttus muss das div drüber sein
                headerStatus.classList.add('bg-white');
                headerStatus.classList.add('top-0');
                headerStatus.classList.add('h-28');
                headerStatus.classList.add('transition');
                headerStatus.classList.add('duration-500');
                headerStatus.classList.add('opacity-90');
            } else {
                headerStatus.classList.remove('bg-white');
            }
        }

        // beim Klick werden weitere Büchere aus der db angezeigt
        async function showMoreBooks() {
            try {
                const response = await fetch(`./getDoneReading.php?limit=${limit}&offset=${offset}`); // Verwenden der php-Datei!
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const books = await response.json();
                console.log(books);

                books.forEach(book => {
                    const li = document.createElement('li');
                    li.className = 'listContainer px-8';
                    li.innerHTML = `<div class="flex flex-row gap-x-4 justify-between items-center py-4">
                                        <p class="flex flex-col text-center w-100 pb-4">
                                            <span class="italic text-xl">${book.title}</span>
                                            <span class="text-sm">${book.author}</span>
                                        </p>
                                        <img class="flex pt-4 pb-8 items-center" src="${book.cover}" alt="Cover von ${book.title}">
                                    </div>
                                    <hr>`;
                    doneContainer.appendChild(li);
                });

                offset += limit;

            } catch (error) {
                console.error(error.message);
            }
        }

        window.addEventListener('scroll', scrollDown);
        btnShowMore.addEventListener('click', showMoreBooks);
    </script>


</body>

</html>