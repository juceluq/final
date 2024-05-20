<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen bg-blue-50 dark:bg-slate-900">
    <header class="bg-white dark:bg-gray-900 py-4 shadow m-4 rounded-lg">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a class="text-xl font-bold text-gray-700 dark:text-gray-300" href={{ route('index') }}>ReservaSphere</a>

            <div class="flex w-full justify-center">
                <form class="flex-grow max-w-xl" action="{{ route('search') }}" method="POST">
                    @csrf
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search" name="query"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                            placeholder="Search Establishments" required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-indigo-600 dark:bg-indigo-700 hover:bg-indigo-800 focus:ring-4 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-gray-300 border border-gray-300 dark:border-gray-600">Search</button>
                    </div>
                </form>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Business')
                        <a href="/establishments/create"
                            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                            <span
                                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Create
                            </span>
                        </a>
                    @endif
                    <div class="relative inline-block text-left">
                        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
                            class="text-gray-700 dark:text-gray-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center z-auto"
                            type="button">
                            {{ Auth::user()->username }}
                            <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdownInformation"
                            class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownInformationButton">
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Client')
                                    <li>
                                        <a href={{ route('myreserves') }}
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                            reserves</a>
                                    </li>
                                @endif
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Business')
                                    <li>
                                        <a href={{ route('mybusinesses') }}
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                            business</a>
                                    </li>
                                @endif
                            </ul>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="rounded-b-lg block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href={{ route('login') }}
                        class="text-gray-700 dark:text-gray-300 font-bold rounded-lg text-lg px-5 inline-flex items-center">Login</a>
                @endauth
                <button id="theme-toggle" type="button"
                    class="w-10 h-10 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-full shadow flex items-center justify-center text-white transition-all ml-4">
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
        </div>
    </header>



    @if (session()->has('alert'))
        <x-alert type="{{ session('alert')['type'] }}" class="my-2 mx-4" title="{{ session('alert')['title'] }}">
            {{ session('alert')['message'] }}
        </x-alert>
    @endif


    <div class="flex-grow container mx-auto my-6 px-6">
        {{ $slot }}
    </div>

    <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-900">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="/"
                    class="hover:underline">ReservaSphere™</a>. All Rights Reserved.</span>
            <ul class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                <li><a href="#" class="hover:underline me-4 md:me-6">About</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Licensing</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdownInformationButton');
            const dropdownMenu = document.getElementById('dropdownInformation');
            const startDateInput = document.getElementById('start-date');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(event) {
                    dropdownMenu.classList.toggle('hidden');
                });

                window.addEventListener('click', function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });

        function confirmDelete(button) {
            const formId = button.getAttribute('data-form-id');
            const form = document.getElementById(formId);
            const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
                .matches;

            const swalOptions = {
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            };


            if (prefersDarkMode) {
                swalOptions.background = '#1f2937';
                swalOptions.color = '#ffffff';
                swalOptions.confirmButtonColor = '#388e3c';
                swalOptions.cancelButtonColor = '#d32f2f';
                swalOptions.iconColor = '#ffffff';
            } else {
                swalOptions.confirmButtonColor = '#3085d6';
                swalOptions.cancelButtonColor = '#d33';
            }

            Swal.fire(swalOptions).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        document.getElementById('price').addEventListener('input', function(e) {
            var value = e.target.value;
            if (value.indexOf('.') >= 0 && value.split('.')[1].length > 2) {
                e.target.value = parseFloat(value).toFixed(2);
            }
        });

        function closeMessage(button) {
            button.parentNode.style.display = 'none';
        }
        document.getElementById('image').onchange = function() {
            if (this.files.length > 3) {
                const prefersDarkMode = window.matchMedia && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches;

                const swalOptions = {
                    title: 'Too Many Files',
                    text: 'You can only upload a maximum of 3 images.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                };

                if (prefersDarkMode) {
                    swalOptions.background = '#1f2937';
                    swalOptions.color = '#ffffff';
                    swalOptions.confirmButtonColor = '#4e4e4e';
                } else {
                    swalOptions.confirmButtonColor = '#3085d6';
                }

                Swal.fire(swalOptions);
                this.value = '';
            }
        };
    </script>

</body>

</html>
