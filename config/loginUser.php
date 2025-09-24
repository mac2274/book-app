<?php
require_once 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginSubmit'])) {
    try {
        $email = $_POST['loginEmail'] ?? '';
        $pwd = $_POST['loginPwd'] ?? '';

        if (empty($email) || empty($pwd)) {
            echo 'Bitte Email und Passwort eingeben.';
        } else {
            echo '<p class="text-center">Login war erfolgreich! <br>
            <strong>Du bist in deinem Journal, ' . $_SESSION['name'] . '.<strong></p>';
        }

        loginUser($email, $pwd);
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

    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="src/img/bj-logo.png">

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
        </a>
    </header>

    <div class="flex flex-col items-center justify-around pt-2">
        <button href="../pages/bookSearch.html"
            class="flex text-md font-semibold text-center p-2 rounded-4xl border-2 border-black hover:bg-white hover:text-green-700 hover:border-green-700 hover:transition duration-500">
            Weiter zur Buchsuche
        </button>
    </div>

</body>

</html>