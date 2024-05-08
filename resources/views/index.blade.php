<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($establishments as $establishment)
                {{-- TODO Establishment card --}}
                <a href="{{ $url ?? '#' }}"
                    class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-lg hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 md:flex-row md:max-w-xl overflow-hidden">
                    <div class="w-full md:w-48 md:h-48 relative">
                        <img src="{{ $establishment->image ? asset('storage/' . $establishment->image) : asset('storage/default.jpg') }}"
                            alt="{{ $establishment->name }}" class="w-full h-full object-cover shadow-lg">
                    </div>
                    <div
                        class="flex flex-col justify-between p-4 leading-normal bg-gradient-to-r ">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white ">
                            {{ $establishment->name }}
                        </h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $establishment->description }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $establishment->category ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $establishment->location ?? 'No location specified' }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
