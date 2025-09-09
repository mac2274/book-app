<?php
// if (require_once 'config/config.db.php') {

//     echo 'done';
// }
?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
        --color-clifford: #da373d;
      }
    </style>
    <title>Book-App - using tailwind.css</title>
</head>


<body class="flex flex-col items-center justify-center  h-screen py-8 bg-green-200">
    <header class="flex flex-col rounded-2xl outline-2 outline-white outline-offset-4 border-white p-6">
        <div class="flex gap-x-4 md:gap-x-8 items-center">
            <img class="w-50 rounded-2xl" src="src/img/bj-logo.png" alt="logo">
            <h1 class="flex flex-col flex-start uppercase tracking-wide text-wrap text-4xl font-bold ">
                <span>Book</span>
                <span>loving</span>
                <span>journal</span>
            </h1>
        </div>
    </header>

    <p class="flex mt-12 px-1 sm:px-20 md:px-40 lg:px-50 text-center">Elit aute et non anim ullamco aute commodo fugiat.
        Consectetur excepteur sunt velit nulla
        incididunt eu
        laboris consectetur fugiat aliquip. Tempor consectetur do dolore non consectetur nisi.
    </p>

    <div class="flex flex-col items-center justify-around pt-2">
        <div class="flex mt-8 gap-x-4 items-center  md:w-80">
            <a href="pages/register.html"
                class="flex items-center justify-center text-white flex-4 text-center py-2 px-1 rounded-2xl border-2 border-transparent bg-orange-400 hover:bg-white hover:text-teal-600 hover:border-2 hover:border-teal-600 transition duration-500">
                Hier zur Registrierung
            </a>
            <a href="pages/login.html"
                class="flex items-center h-full justify-center text-white flex-4 text-center py-2 px-1 rounded-2xl border-2 border-transparent bg-orange-400 hover:bg-white hover:text-teal-600 hover:border-2 hover:border-teal-600 transition duration-500">
                Hier zum Login
            </a>
        </div>
    </div>
</body>

</html>