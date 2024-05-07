<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ReservaSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../resources/app.js"></script>
    <link rel="stylesheet" href="../resources/css/app.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-50 dark:bg-slate-900">

    <header class="bg-white dark:bg-gray-900 py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-xl font-bold text-gray-700 dark:text-gray-300">ReservaSphere</h1>
            <div class="flex">
                <a href="/login" class="text-white font-medium rounded-lg text-xl pr-10 py-2.5">
                    Login
                </a>
                <button id="theme-toggle" type="button"
                    class=" w-10 h-10 bg-blue-500 dark:bg-blue-700 rounded-full shadow flex items-center justify-center text-white focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-all">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
    </header>

    <div class="container mx-auto my-6">{{ $slot }}</div>


    <footer class="bg-white dark:bg-gray-900 py-4 shadow mt-6">
        <div class="container mx-auto px-6">
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">© 2024 ReservaSphere. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>
