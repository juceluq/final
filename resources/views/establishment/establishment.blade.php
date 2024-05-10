<x-app-layout>
    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4 relative z-2">
            <h2
                class="text-2xl font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 px-4 py-2 rounded-lg shadow-lg">
                {{ $establishment->name }}
            </h2>
            <span class="bg-indigo-600 text-purple-200 text-lg font-semibold px-4 py-2 rounded-full shadow-lg">
                {{ number_format($establishment->price, 2) }}€
            </span>
        </div>
        <div class="flex flex-wrap md:flex-nowrap">
            <div class="w-full md:w-1/3">
                <img src="{{ $establishment->image ? asset('storage/' . $establishment->image) : asset('storage/default.jpg') }}"
                    alt="{{ $establishment->name }}" class="w-full h-auto my-4 rounded-3xl">
            </div>

            <div class="w-full md:w-2/3 md:pl-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Location:</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $establishment->location }}</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Category:</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $establishment->category }}</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Description:</p>
                    <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $establishment->description }}</p>
                </div>

                @if (Auth::user()?->role === 'Admin' || Auth::user()?->role === 'Client')
                    {{-- TODO date range picker --}}
                    <div date-rangepicker class="flex items-center mt-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10 a1 1 0 0 1 0 2H5 a1 1 0 0 1 0-2Z">
                                    </path>
                                </svg>
                            </div>
                            <input name="start" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date start">
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10 a1 1 0 0 1 0 2H5 a1 1 0 0 1 0-2Z">
                                    </path>
                                </svg>
                            </div>
                            <input name="end" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date end">
                        </div>
                    </div>
                @elseif (Auth::user()?->role === 'Business')
                    <span
                        class="relative inline-flex items-center justify-center px-3 py-5 text-lg font-bold text-gray-700 mt-3
                        dark:text-gray-300 dark:bg-gray-900 bg-white ">Business
                        cannot reserve establishments.</span>
                @else
                    <div class="mt-9 flex-grow flex items-center justify-center">
                        <div class="relative inline-flex  group">
                            <div
                                class="absolute transitiona-all duration-1000 opacity-70 -inset-px bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] rounded-xl blur-lg group-hover:opacity-100 group-hover:-inset-1 group-hover:duration-200 animate-tilt">
                            </div>
                            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                                class="relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-gray-700
    dark:text-gray-300 transition-all duration-200 dark:bg-gray-900 bg-white font-pj
    rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                                type="button">You must login to reserve this establishment.
                            </button>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Sign in to ReservaSphere
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="/login" method="POST">
                        @csrf
                        <div>
                            <label for="username"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" name="username" id="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                required />
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                required />
                        </div>
                        <button type="submit"
                            class="w-full border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-5 py-2.5 text-center">Login
                            to your account</button>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                            Not registered? <a href="/register"
                                class="text-indigo-600 hover:text-indigo-800 dark:hover:text-indigo-400">Create
                                account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
