<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Bereits gelesene Bücher</title>
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

    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="mt-38 sm:px-10 pb-20 flex flex-col items-center gap-y-4">
            <h2 class="text-4xl font-semibold text-center leading-snug py-4">Deine bereits gelesenen Bücher</h2>
            <ol class="doneReadingList flex flex-col items-center list-decimal list-outside w-full md:w-[600px] lg:w-[760px] px-8">
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
            <a href="../pages/bookShelf.php"
                class="backButton hidden fixed bottom-10 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
                zurück</a>
        </div>

    </main>

    <footer class="flex justify-center w-full">
        <ul class="flex pb-4 pt-40">
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="../pages/datenschutz.php">Datenschutz</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="../pages/barrierefreiheit.php">Barrierefreiheit</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="../pages/impressum.php">Impressum</a>
            </li>
        </ul>
    </footer>


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
                headerStatus.style.backgroundColor = "oklch(97% 0.001 106.424)"; // oklich-color
                headerStatus.classList.add('top-0', 'h-28', 'duration-500', 'opacity-90');
            } else {
                headerStatus.style.backgroundColor = 'transparent';
            }
        }
        // beim scrollen erscheint backButton
        function showBackButton() {
            const showBackButton = document.querySelector('.backButton');
            if (window.scrollY > 100) {
                showBackButton.classList.remove('hidden');
            } else {
                showBackButton.classList.add('hidden');
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
                    li.className = 'listContainer w-100 px-8';
                    li.innerHTML = `<div class="book_container flex flex-row gap-x-4 gap-y-2 justify-between items-center py-4">
                                        <p class="flex flex-col text-center w-100 gap-y-2">
                                            <span class="italic text-xl">${book.title}</span>
                                            <span class="text-sm">${book.author}</span>
                                        </p>
                                        <img class="flex pb-8 items-center" src="${book.cover}" alt="Cover von ${book.title}">
                                    </div>
                                    
                                    <div>
                                        <form class="flex justify-center flex-row mb-8">
                                            <div class="evaluate_container flex flex-col items-center">
                                                <div class="flex gap-x-4">
                                                    <div class="flex items-center">
                                                        <label for="like" class="thumb_like flex flex-col items-center">
                                                            <input type="radio" value="like" name="evalution_book" class="like hidden">
                                                            <img src="../src/img/thumbs-up-solid-empty.svg" class="likeImg w-10" alt="Dieses Buch gefällt mir!">
                                                        </label>
                                                    </div>    
                                                    <div class="flex justify-center">
                                                        <label for="dislike" class="thumb_dislikes flex flex-col items-center">
                                                            <input type="radio" value="dislike" name="evalution_book" class="dislike hidden">
                                                            <img src="../src/img/thumbs-up-solid-empty.svg" class="dislikeImg w-10 rotate-180" alt="Dieses Buch gefällt mir nicht!">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <hr>`;
                    doneContainer.appendChild(li);
                });

                offset += limit;

            } catch (error) {
                console.error(error.message);
            }
        }
        // Bewertung der Bücher mit Thumbs up/down
        document.addEventListener('click', (event) => {
            const container = event.target.closest('.evaluate_container');
            if (!container) return;
            // thumbs up
            const likeClicked = event.target.closest('.likeImg');
            const dislikeClicked = event.target.closest('.dislikeImg');
            // wenn nichts geklickt wurde
            if (!likeClicked && !dislikeClicked) return;
            // Elemente im aktuellen Container holen
            const likeEval = container.querySelector('.like');
            const dislikeEval = container.querySelector('.dislike');
            const likeImg = container.querySelector('.likeImg');
            const dislikeImg = container.querySelector('.dislikeImg');
            // Entferne Texte bevor neue erstellt werden
            container.querySelectorAll('.liked, .disliked').forEach(element => element.remove());
            // wenn thumbs up geklickt ist 
            if (likeClicked) {
                const evalText = document.createElement('p');
                evalText.className = 'liked pt-4 text-green-600';
                evalText.textContent = likeImg.alt;
                container.appendChild(evalText);
                console.log('Like');

                likeEval.checked = true;
                dislikeEval.checked = false;
                likeImg.src = '../src/img/thumbs-up-solid-full.svg';
                dislikeImg.src = '../src/img/thumbs-up-solid-empty.svg';
            }
            // wenn thumbs down geklickt ist
            if (dislikeClicked) {
                const evalText = document.createElement('p');
                evalText.className = 'disliked pt-4 text-red-600';
                evalText.textContent = dislikeImg.alt;
                container.appendChild(evalText);
                console.log('DisLike');

                dislikeEval.checked = true;
                likeEval.checked = false;
                dislikeImg.src = '../src/img/thumbs-up-solid-full.svg';
                likeImg.src = '../src/img/thumbs-up-solid-empty.svg';
            }
        });

        window.addEventListener('scroll', scrollDown);
        window.addEventListener('scroll', showBackButton);
        btnShowMore.addEventListener('click', showMoreBooks);
    </script>


</body>

</html>