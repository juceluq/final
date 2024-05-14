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
                <div id="indicators-carousel" class="relative w-full" data-carousel="static">
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                            <img src="{{ asset('storage/images/' . $establishment->images[0]->filename) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $establishment->name }}">
                        </div>

                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage/images/' . $establishment->images[1]->filename) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $establishment->name }}">
                        </div>

                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage/images/' . $establishment->images[2]->filename) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $establishment->name }}">
                        </div>
                    </div>

                    <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                        <button type="button" class="w-3 h-3 rounded-full bg-white" aria-current="true"
                            aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 2"
                            data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-label="Slide 3"
                            data-carousel-slide-to="2"></button>
                    </div>

                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>

                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>

            </div>

            <div class="w-full md:w-2/3 md:pl-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Location:</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $establishment->location }}</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Category:</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $establishment->category }}</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Description:</p>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $establishment->description }}</p>
                </div>

                @if (Auth::user()?->role === 'Admin' || Auth::user()?->role === 'Client')

                    @if ($alreadyReserved)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mt-3">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">You have already reserved
                                this establishment.</h2>
                        </div>
                    @else
                        <form class="space-y-4" action="{{ route('reserva.store') }}" method="POST">
                            @csrf
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mt-3">
                                <div class="flex flex-col md:flex-row md:justify-between ml-4">
                                    <div class="mb-4 md:mb-0 md:w-1/2 pr-5">
                                        <label for="name"
                                            class="text-lg font-semibold text-gray-700 dark:text-gray-300">Name:</label>
                                        <input type="text" id="name" value="{{ Auth::user()->name }}" readonly
                                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                    <div class="mb-4 md:mb-0 md:w-1/2 pr-10">
                                        <label for="email"
                                            class="text-lg font-semibold text-gray-700 dark:text-gray-300">Email:</label>
                                        <input type="email" id="email" value="{{ Auth::user()->email }}" readonly
                                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                </div>
                                <div class="mb-4 flex flex-col md:flex-row md:justify-between pr-10 mt-3 ml-4">
                                    <div class="mb-4 md:mb-0 md:w-1/2">
                                        <label for="start-date"
                                            class="text-lg font-semibold text-gray-700 dark:text-gray-300">Start
                                            Date:</label>
                                        <input type="date" id="start-date" name="start_date"
                                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                    <div class="mb-4 md:mb-0 md:w-1/2 md:pl-5">
                                        <label for="end-date"
                                            class="text-lg font-semibold text-gray-700 dark:text-gray-300">End
                                            Date:</label>
                                        <input type="date" id="end-date" name="end_date"
                                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                </div>

                                <div class="mb-4 flex flex-col md:flex-row items-center pr-10 mt-3 ml-4">
                                    <div class="mb-4 md:mb-0 md:w-1/2 relative">
                                        <label for="phone-input"
                                            class="text-lg font-semibold text-gray-700 dark:text-gray-300">Phone
                                            number:</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" viewBox="0 0 19 18">
                                                    <path
                                                        d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                                </svg>
                                            </div>
                                            <input type="number" id="phone-input"
                                                aria-describedby="helper-text-explanation" name="phone" required
                                                max="999999999" min="100000000"
                                                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                placeholder="Example: 626203212" />
                                        </div>
                                        <p id="helper-text-explanation"
                                            class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Select a phone number that matches the format.</p>
                                    </div>
                                    <button id="reserve-button" type="submit"
                                        class="relative inline-flex items-center justify-center p-0.5 mt-1 ml-5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                                        <span
                                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                            Reserve
                                        </span>
                                    </button>
                                    <div id="total-price"
                                        class="text-lg font-semibold text-gray-700 dark:text-gray-300 ml-2">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="establishment_id" name="establishment_id"
                                value="{{ $establishment->id }}">
                        </form>
                    @endif
                @elseif (Auth::user()?->role === 'Business')
                    @if (Auth::user()->id == $establishment->user_id)
                    
                        <span>HOLAAAA</span>
                    @else
                        <span
                            class="relative inline-flex items-center justify-center px-3 py-5 text-lg font-bold text-gray-700 mt-3
                            dark:text-gray-300 dark:bg-gray-900 bg-white ">Business
                            cannot reserve establishments.
                        </span>
                    @endif
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('login') }}" method="POST">
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reserve-button').prop('disabled', true);

            function calcularPrecioTotal() {
                var startDate = new Date($('#start-date').val());
                var endDate = new Date($('#end-date').val());
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (!isNaN(startDate) && !isNaN(endDate) && startDate >= currentDate && startDate < endDate) {
                    var differenceInMs = endDate - startDate;
                    var differenceInDays = differenceInMs / (1000 * 60 * 60 * 24);
                    var establishmentPrice = {{ $establishment->price }};
                    var totalPrice = differenceInDays * establishmentPrice;

                    $('#total-price').text('Total Price: ' + totalPrice.toFixed(2) + '€');
                    $('#total-price').show();

                    $('#reserve-button').prop('disabled', totalPrice <= 0 || isNaN(totalPrice));
                } else {
                    if (startDate < currentDate) {
                        $('#total-price').text('Start date cannot be in the past.');
                    } else if (startDate >= endDate) {
                        $('#total-price').text('End date must be later than start date.');
                    } else {
                        $('#total-price').text('Dates must be correct.');
                    }
                    $('#reserve-button').prop('disabled', true);
                }
            }

            $('#start-date, #end-date').on('change', function() {
                calcularPrecioTotal();
            });

            $('#total-price').hide();
        });
    </script>

</x-app-layout>
