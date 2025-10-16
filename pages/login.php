<?php
require_once '../config/lib.php';

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

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
    <link href="../src/output.css" rel="stylesheet">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../src/img/bj-logo.png">
</head>

<body class="flex flex-col min-h-screen bg-green-200">

    <header class="fixed w-full flex justify-between items-start">
        <div class="flex gap-x-4 items-center p-4">
            <a href="../index.html" class="flex item-center ">
                <img class="flex w-20 h-20 rounded-2xl" src="../src/img/bj-logo.png" alt="logo">
            </a>
            <h1 class="flex flex-col uppercase w-20 tracking-wide text-2xl leading-none font-bold">
                <a href="../index.html">
                    <span>Book</span>
                    <span>loving</span>
                    <span>journal</span>
                </a>
            </h1>
        </div>

    </header>

    <main class="flex flex-grow gap-y-4 flex-col items-center justify-center px-6">

        <h2 class="text-4xl font-semibold py-4">Login</h2>

        <!-- Login-Message geben -->
        <?php if ($error): ?>
            <p class="text-red-500"><?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form action="" method="POST" class="grid gap-y-4">
            <div class="grid grid-cols-3 items-center">
                <label for="loginEmail" class="text-xl">Email</label>
                <input type="email" id="loginEmail" name="loginEmail" required
                    class="grid col-span-2 border-2 border-back rounded-3xl p-2 focus:bg-white">
            </div>
            <div class="grid grid-cols-3 items-center">
                <label for="loginPwd" class="text-xl">Password</label>
                <input type="password" id="loginPwd" name="loginPwd" required
                    class="col-span-2 border-2 border-back rounded-3xl p-2 focus:bg-white">
            </div>
            <div class="grid grid-cols-3 items-center">
                <input type="submit" value="Einloggen" name="loginSubmit"
                    class="col-start-2 border-2 border-transparent rounded-3xl p-2 text-green-200 bg-black hover:bg-white hover:text-teal-600 hover:border-2 hover:border-teal-600 transition duration-500">
            </div>
        </form>

        <p>Noch nicht registriert? Dann <a href="register.html" class="underline">registriere</a> dich jetzt hier!</p>

        <div class="flex w-full justify-end">
            <a href="../pages/home.php"
                class="backButton fixed bottom-10 right-4 bg-black border-transparent border-2 text-white rounded-4xl p-2 hover:bg-green-200 hover:text-black hover:border-black hover:transition duration-500">
                zurück</a>
        </div>
    </main>

    <footer class="flex justify-center mb-4">
        <ul class="flex flex-col items-center sm:flex-row gap-x-2">
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="pages/datenschutz.php">Datenschutz</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="pages/Barrierefreiheit.php">Barrierefreiheit</a>
            </li>
            <li class="hover:bg-green-800 hover:text-white hover:rounded-2xl py-1 px-2">
                <a href="pages/impressum.php">Impressum</a>
            </li>
        </ul>
    </footer>
</body>

</html>