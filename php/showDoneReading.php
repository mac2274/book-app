<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css?v=2" rel="stylesheet">
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
                class="logoutBtn justify-self-right bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a>
        </div>
    </header>

    <main class="flex flex-grow flex-col item-center justify-center px-6">
        <div id="searchDiv" class="mt-38 sm:px-10 pb-20 flex flex-col items-center gap-y-4">
            <h2 class="text-4xl font-semibold text-center leading-snug py-4">Deine bereits gelesenen Bücher</h2>
            <ol
                class="doneReadingList flex flex-col items-center list-decimal list-outside w-full md:w-[600px] lg:w-[760px] px-8">
                <?php showDoneReading() ?>
            </ol>

            <!-- ------------------ Button für weitere Bücher -->
            <button
                class="showMore mb-10 border-teal-600 border-1 text-teal-600 rounded-4xl p-2 hover:bg-teal-600 hover:text-white hover:transition duration-500">
                mehr anzeigen
            </button>
        </div>

        <!-- ----------------------- zurück-button  ------------->
        <div class="flex w-full justify-end">
            <a href="../pages/bookShelf.php"
                class="backButton hidden fixed bottom-10 right-4 bg-black border-transparent border-1 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
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
            if (window.scrollY > 0) {

                // headerSttus muss das div drüber sein
                headerStatus.style.backgroundColor = "oklch(97% 0.001 106.424)"; // oklich-color
                headerStatus.classList.add('top-0', 'h-28', 'duration-500', 'opacity-90', 'z-999');
            } else {
                headerStatus.style.backgroundColor = 'transparent';
            }
        }

        // beim scrollen erscheint backButton
        function showBackButton() {
            const showBackButton = document.querySelector('.backButton');
            if (window.scrollY > 00) {
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
                                    
                                    <div class="evaluate_container flex flex-col items-center mb-8 z-0">
                                        <div class="flex gap-4 w-100 justify-center">
                                            <form action="saveRating.php" method="POST" class="flex flex-row gap-4 justify-center w-100">
                                                <label>
                                                    <input type="hidden" name="bookId" value="${book.id}">
                                                </label>
                                                <div class="flex flex-row gap-4 justify-center w-full">
                                                    <label class="thumb_like flex flex-col items-center">
                                                        <input type="radio" value="1" name="evalution_book" class="like hidden">
                                                        <svg class="likeSvgEmpty w-9 hover:text-green-600 transition-colors duration-500" 
                                                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                        </svg>
                                                        <svg class="likeSvgFilled w-9 hidden text-green-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <desc>Dieses Buch gefällt mir!</desc>
                                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                        </svg>
                                                    </label>
                                                    <label class="thumb_dislike flex flex-col items-center">
                                                        <input type="radio" value="0" name="evalution_book" class="dislike hidden">
                                                        <svg class="dislikeSvgEmpty rotate-180 w-9 hover:text-red-600 transition-colors duration-500" 
                                                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                        </svg>
                                                        <svg class="dislikeSvgFilled rotate-180 w-9 hidden text-red-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <desc>Dieses Buch gefällt mir nicht.</desc>
                                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                        </svg>
                                                    </label> 
                                                </div>       
                                            </form>          
                                        </div>
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
            const likeClicked = event.target.closest('.likeSvgEmpty');
            const dislikeClicked = event.target.closest('.dislikeSvgEmpty');
            // wenn nichts geklickt wurde
            if (!likeClicked && !dislikeClicked) return;
            // Elemente im aktuellen Container holen
            const likeEval = container.querySelector('.like');
            const dislikeEval = container.querySelector('.dislike');
            const likeSvgEmpty = container.querySelector('.likeSvgEmpty');
            const likeSvgFilled = container.querySelector('.likeSvgFilled');
            const dislikeSvgEmpty = container.querySelector('.dislikeSvgEmpty');
            const dislikeSvgFilled = container.querySelector('.dislikeSvgFilled');
            // Entferne Texte bevor neue erstellt werden
            container.querySelectorAll('.liked, .disliked').forEach(element => element.remove());
            // wenn thumbs up geklickt ist 
            if (likeClicked) {
                const evalText = document.createElement('p');
                evalText.className = 'liked pt-4 text-green-600';
                evalText.textContent = likeSvgFilled.querySelector('desc').textContent;
                container.appendChild(evalText);

                likeEval.checked = true;
                dislikeEval.checked = false;
                likeSvgEmpty.classList.add('hidden');
                likeSvgFilled.classList.remove('hidden');
                dislikeSvgEmpty.classList.remove('hidden');
                dislikeSvgFilled.classList.add('hidden')
            }
            // wenn thumbs down geklickt ist
            if (dislikeClicked) {
                const evalText = document.createElement('p');
                evalText.className = 'disliked pt-4 text-red-600';
                evalText.textContent = dislikeSvgFilled.querySelector('desc').textContent;
                container.appendChild(evalText);

                dislikeEval.checked = true;
                likeEval.checked = false;
                dislikeSvgEmpty.classList.add('hidden');
                dislikeSvgFilled.classList.remove('hidden');
                likeSvgEmpty.classList.remove('hidden');
                likeSvgFilled.classList.add('hidden')
            }
        });

        window.addEventListener('scroll', scrollDown);
        window.addEventListener('scroll', showBackButton);
        btnShowMore.addEventListener('click', showMoreBooks);
    </script>


</body>

</html>