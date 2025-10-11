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

    <title>Favouriten</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="flex flex-col min-h-screen bg-green-200">

    <header class="fixed w-full flex justify-between items-start">
        <div class="flex gap-x-4 items-center p-4">
            <a href="../pages/home.php" class="flex item-center ">
                <img class="flex w-20 h-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">
            </a>
            <h1 class="flex flex-col uppercase w-20 tracking-wide text-2xl leading-none font-bold">
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

    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="mt-38 px-10 pb-20 flex flex-col items-center gap-y-4">
            <h2 class="text-4xl font-semibold mt-4">Deine Favouriten</h2>
            <ol class="favList list-decimal list-outside w-xl px-8">
                <?php showFavs() ?>
            </ol>

            <!-- ------------------ Button für weitere Bücher -->
            <button
                class="showMore mb-10 border-teal-600 border-1 text-teal-600 rounded-4xl p-2 hover:bg-teal-600 hover:text-white  duration-500">
                mehr anzeigen
            </button>
        </div>

        <!-- ----------------------- zurück-button  -->
        <div class="flex w-full justify-end">
            <a href="../pages/bookShelf.php"
                class="backButton fixed bottom-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black  duration-500">
                zurück</a>
        </div>

    </main>

    <footer class="flex justify-center w-full">
        <ul class="flex pb-10 pt-40">
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
        const headerStatus = document.querySelector('header');
        const favContainer = document.querySelector('.favList');
        const btnShowMore = document.querySelector('.showMore');

        const limit = 10;
        let offset = 10;

        // header wird weiß beim vertikalen Scrollen
        function scrollDown() {
            if (window.scrollY > 50) {

                // headerSttus muss das div drüber sein
                headerStatus.style.backgroundColor = "oklch(97% 0.001 106.424)"; // oklich-color
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
                const response = await fetch(`./getFavs.php?limit=${limit}&offset=${offset}`); // Verwenden der php-Datei!
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const books = await response.json();
                console.log(books);

                books.forEach(book => {
                    const li = document.createElement('li');
                    li.className = 'listContainer p-4';
                    li.innerHTML = `<div class="flex flex-col items-center gap-y-2">
                                        <p class="flex flex-col text-center gap-y-2">
                                            <span class="font-bold italic text-xl">${book.title}</span>
                                            <span class="text-sm"> - ${book.author} - </span>
                                        </p>
                                        <div class="flex flex-col items-center">
                                            <button type="button" class="reveal_more my-4 border-1 rounded-3xl py-1 px-2 hover:bg-green-800 hover:text-white hover:ease-in-out hover:duration-500" data-desc="${book.description}">
                                                Beschreibung
                                            </button> 
                                        </div>
                                        <img class="flex pt-4 pb-8 items-center" src="${book.cover}" alt="Cover von ${book.title}">
                                    </div>
                                    <hr>`;
                    favContainer.appendChild(li);
                });

                offset += limit;

            } catch (error) {
                console.error(error.message);
            }
        }

        document.addEventListener('click', (event) => {
            const button = event.target.closest(".reveal_more");
            let revealDescript = document.querySelector('.revealDiv');

            if (revealDescript) {
                revealDescript.remove();
            } else {
                revealDescript = document.createElement("div");
                let descript = button.dataset.desc ?? "";
                if (!descript.trim()) descript = "Keine Beschreibung vorhanden."; revealDescript.textContent = descript;
                revealDescript.className = "revealDiv pt-4 text-sm";
                button.parentElement.appendChild(revealDescript);
            }
        });

        window.addEventListener('scroll', scrollDown);
        btnShowMore.addEventListener('click', showMoreBooks);

    </script>

</body>

</html>