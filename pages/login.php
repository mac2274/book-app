<?php
session_start();

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Login</title>
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
        </a>
    </header>

    <h2 class="text-2xl font-semibold">Login</h2>

    <!-- Login-Message geben -->
    <?php if ($error): ?>
        <p class="text-red-500"><?= htmlspecialchars($error) ?> </p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="text-green-500"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form action="./home.php" method="POST" class="grid gap-y-4">
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
</body>

</html>