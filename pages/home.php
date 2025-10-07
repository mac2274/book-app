<?php
require_once '../config/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
    $email = $_POST['loginEmail'] ?? '';
    $pwd = $_POST['loginPwd'] ?? '';


    try {
        if (loginUser($email, $pwd)) {
            header('Location: ./home.php?success=' . urlencode('Erfolgreich eingeloggt.'));
            exit;
        } else { 
            header('Location: ./login.php?error=' . urlencode('Die Engaben stimmen nicht ganz ...'));
          exit;
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Book Journal</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">

</head>

<body class="relative flex flex-col items-center justify-center gap-y-10 h-screen bg-green-200 p-4">
    <header class="absolute top-4 left-4 flex w-40 gap-x-4 items-center">
        <img class="flex w-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">

        <h1 class="flex flex-col uppercase tracking-wide text-2xl leading-none font-bold">
            <a href="../index.html">
                <span>Book</span>
                <span>loving</span>
                <span>journal</span>
            </a>
        </h1>

        <!-- logout-button -->
        <a href="../php/logout.php" class="logoutBtn fixed top-4 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">Ausloggen</a> 
    </header>

    <div class="flex flex-col items-center">
        <h2 class="text-3xl text-center font-semibold py-4 mb-4">
            <?php if ($_SESSION['name']) {
                echo 'Willkommen zurück <br>in deinem Book Journal, <br> <em class="text-4xl">' . $_SESSION['name'] . '</em>!';
            } ?>
        </h2>
        <div class="flex flex-row gap-2 flex-wrap justify-center">
            <a href="./bookSearch.html"
                class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                Weiter zur Buchsuche
            </a>
            <a href="./bookShelf.html"
                class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                Zu deiner Bibliothek
            </a>

            <a href="./.html"
                class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                wohin noch
            </a>
            <a href="./.html"
                class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
                eine Idee?
            </a>
        </div>
    </div>
    

</body>

</html>