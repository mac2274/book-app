<?php
require_once '../config/lib.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Buchsuche</title>
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

    <main class="flex pt-38 flex-grow flex-col item-center gap-y-4 justify-center px-6">
        <div id="searchDiv" class="flex flex-col justify-content items-center gap-y-4">
            <h2 class="text-4xl font-semibold py-4">Buchsuche</h2>
            <form action="" class="flex flex-col gap-4">
                <!--------------------------------------------------------- keine action nötig? -->
                <div class="flex flex-row items-center gap-x-4">
                    <label for="title" class="text-xl">Titel</label>
                    <input type="text" id="title" class="border-2 rounded-3xl w-100 p-2 focus:bg-white" required>
                </div>

                <div class="flex justify-center">
                    <input type="submit" value="Suchen"
                        class="border-2 border-transparent rounded-4xl py-2 px-6 text-green-200 bg-black hover:bg-white hover:text-teal-600 hover:border-2 hover:border-teal-600 transition duration-500">
                </div>
            </form>
        </div>

        <div id="result" class="flex flex-col items-center gap-3"></div>

        <!-- ----------------------- zurück-button  -->
        <div class="w-full justify-end">
            <a href="../pages/home.php"
                class="backButton fixed bottom-10 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
                zurück</a>
        </div>

    </main>

    <footer class="flex justify-center items-end h-full">
        <ul class="flex pb-4">
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
        let searchDiv = document.querySelector('#searchDiv');
        let input = document.querySelector('#title');
        const searchResult = document.querySelector('#result');
        const searchURL = "https://www.googleapis.com/books/v1/volumes?q=";
        // header wird weiß beim vertikalen Scrollen
        const headerStatus = document.querySelector('header');

        // Beim scrollDown wird der header weiß
        function scrollDown() {
            if (window.scrollY > 40) {

                // headerSttus muss das div drüber sein
                headerStatus.style.backgroundColor = "oklch(97% 0.001 106.424)"; // oklich-color
                headerStatus.classList.add('top-0');
                headerStatus.classList.add('h-28');
                headerStatus.classList.add('transition');
                headerStatus.classList.add('duration-500');
                headerStatus.classList.add('opacity-90');
            } else {
                headerStatus.style.backgroundColor = 'transparent';
            }
        }

        // beim scrollDown erscheint zurück-Button
        function showBackBtn() {
            const backButton = document.querySelector('.backButton');
            if (window.scrollY > 200) {
                backButton.classList.remove('hidden');
                // backButton.classList.add('flex');
            } else {
                backButton.classList.add('hidden');;
            }
        }

        // // in Fav-liste (DB) speichern mit fetch
        async function addToFavs(book, bookDiv) {
            try {
                // speicherort angeben
                const response = await fetch('../php/saveFavs.php', {
                    method: 'POST', // speichern mit POST
                    headers: {
                        'Content-Type': 'application/json' // als json speichern
                    },
                    body: JSON.stringify(book) // nimmt book-variable in string damit lesbar für php
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();

                // Rückmeldung in div geben
                let msgContainer = bookDiv.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                msgContainer.textContent = json.message;

                console.log('Server-Antwort:', json);
            } catch (error) {
                console.error(error);
                let msgContainer = document.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                msgContainer.textContent = 'Fehler beim Speichern!';
            }
        }
        // in doneReading-liste speichern
        async function addToDone(book, bookDiv) {
            try {
                const response = await fetch('../php/saveDoneReading.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(book)
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();

                // Rückmeldung nachSpeicherung
                let msgContainer = bookDiv.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 border-4 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                msgContainer.textContent = json.message;
                console.log('Server-Antwort:', json);
            } catch (error) {
                console.error(error);
                //Fehlermeldung anzeigen
                let msgContainer = bookDiv.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                msgContainer.textContent = 'Fehler beim Speichern!';
            }
        }

        async function addToReads(book, bookDiv) {
            try {
                const response = await fetch('../php/saveToReads.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(book)

                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                // JSON aus PHP: json ist das 'result' 
                const json = await response.json();

                // div für Rückmeldung nach Speicherung
                let msgContainer = bookDiv.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                // Nachricht von der Datei(PHP)
                msgContainer.textContent = json.message;

                console.log('Server-Antwort:', json);
            } catch (error) {
                console.error(error);

                //Fehlermeldung anzeigen
                let msgContainer = bookDiv.querySelector('.savingMessage');
                if (!msgContainer) {
                    msgContainer = document.createElement('div');
                    msgContainer.className = ('savingMessage bg-green-800 rounded-3xl text-white p-3');
                    bookDiv.appendChild(msgContainer);
                }
                msgContainer.textContent = 'Fehler beim Speichern!';
            }
        };


        // -> 1. async function mit fetch
        async function getBook(e) {
            e.preventDefault();
            const searchTerm = input.value;
            const url = `${searchURL}${searchTerm}`;

            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);

                // -> 2. results zeigen
                let searchDiv = document.querySelector('#searchDiv')
                // Suche einzeilig machen 
                searchDiv.className = 'flex flex-row';
                document.querySelector('h2').style.display = 'none';
                document.querySelector('form').classList.remove('flex-col');
                document.querySelector('form').classNamme = 'flex-row gap-x-4';
                searchResult.className = 'flex flex-col pt-10';
                searchResult.innerHTML = '';

                // überschrift für Suchergebnis
                const searchHeading = document.createElement('h4');
                searchHeading.className = 'text-3xl self-start';
                searchHeading.innerHTML = 'Suchergebnis:';
                searchResult.appendChild(searchHeading);

                data.items.forEach(item => {
                    // Zugriff auf die neu generierten Bücher/items

                    // Container für Buchinfos (item)
                    const bookDiv = document.createElement('div'); // 3. Variante
                    bookDiv.className = 'createdDiv flex flex-col items-center text-center w-200 gap-y-4 my-4';
                    searchResult.appendChild(bookDiv);

                    // Buchtitel
                    const title = document.createElement('h5');
                    title.className = 'bookTitle font-bold italic';
                    title.textContent = `- Buchtitel: ${item.volumeInfo.title} -`;
                    bookDiv.appendChild(title);

                    // Autor
                    const author = document.createElement('p');
                    author.classList.add('bookauthor');
                    author.textContent = `Autor/innen: ${item.volumeInfo.authors?.join(', ')}`;
                    bookDiv.appendChild(author);

                    // Subtitle
                    const subtitle = document.createElement('p');
                    subtitle.classList.add('bookSubtitle');
                    subtitle.textContent = item.volumeInfo.subtitle ?? "";
                    bookDiv.appendChild(subtitle);

                    // Beschreibung div+button
                    const descriptionDiv = document.createElement('div');
                    bookDiv.appendChild(descriptionDiv);

                    // Button Beschreibung erzeugen
                    const btndescription = document.createElement('button');
                    btndescription.type = "button";
                    btndescription.className = 'bookBtndescription text-md py-1 px-2 rounded-3xl border-1 hover:border-green-800 hover:text-green-800 hover:bg-white';
                    btndescription.textContent = "Beschreibung lesen";
                    descriptionDiv.appendChild(btndescription);

                    // eventlistener für btndescription
                    btndescription.addEventListener('click', () => {
                        let descriptionP = bookDiv.querySelector('.descriptionText');

                        if (descriptionP) {
                            // wenn bereits da, wird es entfernt
                            descriptionP.remove();
                        } else {
                            // andernfalls wird es neugesetzt 
                            descriptionP = document.createElement('p');
                            descriptionP.className = 'descriptionText px-10 py-4 transition duration-300';
                            descriptionP.textContent = item.volumeInfo.description ?? "Keine Beschreibung vorhanden";
                            descriptionDiv.appendChild(descriptionP);
                        }
                    });

                    // Cover
                    const cover = document.createElement('img');
                    cover.classList.add('bookCover');
                    cover.src = item.volumeInfo.imageLinks?.thumbnail;
                    bookDiv.appendChild(cover);

                    // Button addToList erzeugen
                    const addToList = document.createElement('button');
                    addToList.type = "button";
                    addToList.className = 'bookBtndescription text-md  py-1 px-2 rounded-3xl border-1 hover:border-green-800 hover:text-green-800 hover:bg-white hover:transition duration-500';
                    addToList.textContent = "zur Liste hinzufügen";
                    bookDiv.appendChild(addToList);

                    addToList.addEventListener('click', () => {
                        // div für buttons und
                        // dynamisch Buttonliste anzeigen und verstecken
                        let btnLists = bookDiv.querySelector('.btnForLists');

                        if (btnLists) {
                            btnLists.remove();
                        } else {
                            btnLists = document.createElement('div');
                            btnLists.className = 'btnForLists flex gap-x-2';
                            bookDiv.appendChild(btnLists);
                        }

                        // Favs-btn
                        const btnFavs = document.createElement('button');
                        btnFavs.className = 'addToFavs text-md  py-1 px-2 rounded-3xl border-1 hover:border-green-800 hover:text-green-800 hover:bg-white';
                        btnFavs.textContent = 'Favouritenliste';
                        btnLists.appendChild(btnFavs);

                        // buchinfos im btnFavs speichern:
                        btnFavs.dataset.title = item.volumeInfo.title;
                        btnFavs.dataset.author = item.volumeInfo.authors?.join(", ") || "Unbekannt";
                        btnFavs.dataset.subtitle = item.volumeInfo.subtitle ?? "";
                        btnFavs.dataset.description = item.volumeInfo.description ?? "Keine Beschreibung vorhanden";
                        btnFavs.dataset.cover = item.volumeInfo.imageLinks?.thumbnail;

                        // listener für addtoFavs
                        btnFavs.addEventListener('click', () => {
                            // Daten aus Api in button speichern für php/db
                            const book = {
                                title: btnFavs.dataset.title,
                                author: btnFavs.dataset.author,
                                subtitle: btnFavs.dataset.subtitle,
                                description: btnFavs.dataset.description,
                                cover: btnFavs.dataset.cover
                            }
                            addToFavs(book, bookDiv);
                        });

                        // btn already read/done
                        const btnDone = document.createElement('button');
                        btnDone.className = ('addToDoneReading text-md  py-1 px-2 rounded-3xl border-1 hover:border-green-800 hover:text-green-800 hover:bg-white');
                        btnDone.textContent = 'bereits gelesen';
                        btnLists.appendChild(btnDone);

                        // buchinfos im btnDone speichern:
                        btnDone.dataset.title = item.volumeInfo.title;
                        btnDone.dataset.author = item.volumeInfo.authors?.join(", ") || "Unbekannt";
                        btnDone.dataset.cover = item.volumeInfo.imageLinks.thumbnail;

                        // listener für already read
                        btnDone.addEventListener('click', () => {
                            const book = {
                                title: btnDone.dataset.title,
                                author: btnDone.dataset.author,
                                cover: btnDone.dataset.cover
                            }
                            addToDone(book, bookDiv);
                        })

                        // btn to be read
                        const btnToRead = document.createElement('button');
                        btnToRead.className = 'addToBeRead text-md  py-1 px-2 rounded-3xl border-1 hover:border-green-800 hover:text-green-800 hover:bg-white';
                        btnToRead.textContent = 'Leseliste';
                        btnLists.appendChild(btnToRead);

                        // buchinfos im to-read bttn speichern:
                        btnToRead.dataset.title = item.volumeInfo.title;
                        btnToRead.dataset.author = item.volumeInfo.authors?.join(", ") || "Unbekannt";
                        btnToRead.dataset.subtitle = item.volumeInfo.subtitle ?? "";
                        btnToRead.dataset.description = item.volumeInfo.description ?? "Keine Beschreibung vorhanden";
                        btnToRead.dataset.cover = item.volumeInfo.imageLinks?.thumbnail;

                        // eventlistener für ToRead
                        btnToRead.addEventListener('click', () => {
                            const book = {
                                title: btnToRead.dataset.title,
                                author: btnToRead.dataset.author,
                                subtitle: btnToRead.dataset.subtitle,
                                description: btnToRead.dataset.description,
                                cover: btnToRead.dataset.cover
                            }
                            addToReads(book, bookDiv);
                        })
                    })
                })

            } catch (error) {
                console.error(error.message);
            }
        }

        window.addEventListener('scroll', showBackBtn);
        window.addEventListener('scroll', scrollDown);
        document.querySelector('form').addEventListener('submit', getBook);

    </script>
</body>

</html>