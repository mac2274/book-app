<?php
require_once '../config/lib.php';

$userId = $_SESSION['userId'] ?? NULL;
if (!$userId) {
    header('Location: ./login.php?error=' . urlencode('Bitte zuerst einloggen.'));
    exit;
}

$success = $_GET['success'] ?? 'Erfolgreich eingeloggt!';

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">

    <title>Book Journal</title>
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
        <div class="flex flex-col gap-y-4 items-center">
            <?php if ($success): ?>
                <p><?= htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <h2 class="flex gap-4 flex-col text-3xl text-center font-semibold font-display py-4">
                <?php if (!empty($_SESSION['name'])): ?>
                    <?php
                        $safeName = htmlspecialchars($_SESSION['name']);
                        echo 'Willkommen zurück <br>in deinem Book Journal, <br> <span class="niceFont text-6xl py-4">' . $safeName . '!</span>';
                    ?>
                <?php endif; ?>
            </h2>

            <div class="flex flex-row gap-2 flex-wrap justify-center">
                <a href="./bookSearch.php"
                    class="flex text-md font-semibold text-center p-2 rounded-4xl border-1 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                    Weiter zur Buchsuche
                </a>
                <a href="./bookShelf.php"
                    class="flex text-md font-semibold text-center p-2 rounded-4xl border-1 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                    Zu deiner Bibliothek
                </a>
            </div>
        </div>
    </main>

    <footer class="flex justify-center">
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
</body>

</html>