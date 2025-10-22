<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Leseliste</title>
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
                class="logoutBtn justify-self-right bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>

    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="mt-38 sm:px-10 flex flex-col items-center gap-y-4">
            <h2 class="text-4xl font-semibold text-center leading-snug text-2 block py-4">Deine Leseliste</h2>
            <ol class="toBeReadList flex flex-col items-center list-decimal list-outside w-full md:w-[600px] lg:w-[760px] md:w-3xl px-8">
                <?php showToRead() ?>
            </ol>

            <!-- ------------------ Button für weitere Bücher -->
            <button
                class="showMore mb-10 border-teal-600 border-1 text-teal-600 rounded-4xl p-2 hover:bg-teal-600 hover:text-white hover:transition duration-500">
                mehr anzeigen
            </button>
        </div>

        <!-- ----------------------- zurück-button  -->
        <div class="flex w-full justify-end">
            <a href="../pages/bookShelf.php"
                class="backButton hidden fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
                zurück</a>
        </div>
    </main>

    <footer class="flex justify-center w-full pb-4 pt-40">
        <ul class="flex">
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
        const toReadList = document.querySelector('.toBeReadList');
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
            if (window.scrollY > 0) {
                showBackButton.classList.remove('hidden');
            } else {
                showBackButton.classList.add('hidden');
            }
        }
        // beim Klick werden weitere Büchere aus der db angezeigt
        async function showMoreBooks() {
            try {
                const response = await fetch(`./getToBeRead.php?limit=${limit}&offset=${offset}`); // fetch der PHP-Datei! 
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const books = await response.json();
                console.log(books);

                books.forEach(book => {
                    const li = document.createElement('li');
                    li.className = 'listContainer w-100 p-4';
                    li.innerHTML = `<div class="book_container flex flex-col items-center gap-y-4">
                                        <p class="flex flex-col text-center gap-y-2"> 
                                            <span class="italic text-xl">${book.title}</span>
                                            <span class="text-sm">- ${book.author} -</span>
                                        </p>
                                        <div class="flex flex-col items-center">
                                            <button type="button" class="reveal_more border-1 bg-green-900 text-white rounded-3xl py-1 px-3 hover:bg-green-800 hover:text-orange-200 hover:transition ease-in-out duration-500" data-desc="${book.description}">
                                                Beschreibung
                                            </button>
                                        </div>
                                        <img class="flex pb-8 items-center" src="${book.cover}" alt="Cover von ${book.title}">
                                    </div>
                                    <hr>`;
                    toReadList.appendChild(li);
                });

                offset += limit;

            } catch (error) {
                console.error(error.message);
            }
        }
        // beim Klick wird eine vorhandene Beschreibung angezeigt
        document.addEventListener("click", (event) => {
            const button = event.target.closest('.reveal_more');
            let revealDescript = document.querySelector('.revealDiv');

            if (revealDescript) {
                revealDescript.remove();
            } else {
                revealDescript = document.createElement("div");
                let descript = button.dataset.desc ?? 'Keine Beschreibung vorhanden';// holt die Beschreibung
                revealDescript.textContent = descript;
                revealDescript.className = "revealDiv pt-4 text-sm";
                button.parentElement.appendChild(revealDescript);
            }
        });
        // Bewertung der Bücher mit Thumbs up/down
        document.querySelectorAll('.evaluate_container').forEach(container => {
            container.addEventListener('click', (event) => {
                // thumbs up
                const likeClicked = event.target.closest('.likeImg');
                const dislikeClicked = event.target.closest('.dislikeImg');

                const likeEval = container.querySelector('.like');
                const dislikeEval = container.querySelector('.dislike');
                const likeImg = container.querySelector('.likeImg');
                const dislikeImg = container.querySelector('.dislikeImg');
                const evalContainer = container;
                // wenn nichts geklickt wurde
                if (!likeClicked && !dislikeClicked) return;
                // Entferne Texte bevor neue erstellt werden
                container.querySelectorAll('.liked, .disliked').forEach(element => element.remove());
                // wenn thumbs up geklickt ist 
                if (likeClicked) {
                    const evalText = document.createElement('p');
                    evalText.className = 'liked pt-4 text-green-600';
                    evalText.textContent = likeImg.alt;
                    evalContainer.appendChild(evalText);
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
                    evalContainer.appendChild(evalText);
                    console.log('DisLike');

                    dislikeEval.checked = true;
                    likeEval.checked = false;
                    dislikeImg.src = '../src/img/thumbs-up-solid-full.svg';
                    likeImg.src = '../src/img/thumbs-up-solid-empty.svg';
                }
            });
        });


        window.addEventListener('scroll', scrollDown);
        window.addEventListener('scroll', showBackButton);
        btnShowMore.addEventListener('click', showMoreBooks);
    </script>


</body>

</html>