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
                @else
                    <div class="mt-9 flex-grow flex items-center justify-center">
                        <a href="{{ route('login') }}"
                            class="py-5 px-4 border border-transparent rounded-md shadow-sm text-8xl font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login
                        </a>


                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
