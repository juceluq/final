<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($establishments as $establishment)
                <div class="relative group">
                    @if (auth()->check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Business'))
                        <button type="button" onclick="confirmDelete(this)"
                            data-form-id="delete-form-{{ $establishment->id }}"
                            class="absolute right-2 top-2 hidden group-hover:flex justify-center items-center bg-red-500 text-white rounded-full w-10 h-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                        <form id="delete-form-{{ $establishment->id }}" method="POST"
                            action="{{ route('establishments.destroy', $establishment) }}" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                    <a href="{{ route('establishments.show', $establishment->id) }}"
                        class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-lg hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 md:flex-row md:max-w-xl overflow-hidden">
                        <div class="w-full md:w-48 md:h-48 relative">
                            <span
                                class="absolute top-2 left-2 bg-white bg-opacity-90 rounded-full px-3 py-1 text-xs font-semibold text-gray-900 shadow">
                                {{ number_format($establishment->price, 2) }}€
                            </span>
                            <img src="{{ $establishment->image ? asset('storage/' . $establishment->image) : asset('storage/default.jpg') }}"
                                alt="{{ $establishment->name }}" class="w-full h-full object-cover shadow-lg rounded-lg">
                        </div>
                        <div class="flex flex-col justify-between p-4 leading-normal">
                            @foreach (split_title($establishment->name, 11) as $line)
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $line }}
                                </h5>
                            @endforeach
                            @foreach (split_description($establishment->description, 20) as $part)
                                <p class="mb-1 font-normal text-gray-700 dark:text-gray-400">
                                    {{ $part }}
                                </p>
                            @endforeach
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
