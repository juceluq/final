@props([
    'type' => 'info',
    'title' => '',
])

@switch($type)
    @case('info')
        @php $class = 'text-blue-800 bg-white dark:bg-gray-900 dark:text-blue-400 border border-blue-300 dark:border-blue-800' @endphp
    @break

    @case('danger')
        @php $class = 'text-red-800 bg-white dark:bg-gray-900 dark:text-red-400 border border-red-300 dark:border-red-800' @endphp
    @break

    @case('success')
        @php $class = 'text-green-800 bg-white dark:bg-gray-900 dark:text-green-400 border border-green-300 dark:border-green-800' @endphp
    @break

    @case('warning')
        @php $class = 'text-yellow-800 bg-white dark:bg-gray-900 dark:text-yellow-400 border border-yellow-300 dark:border-yellow-800' @endphp
    @break

    @case('dark')
        @php $class = 'text-gray-800 bg-white dark:bg-gray-900 dark:text-gray-400 border border-gray-300 dark:border-gray-800' @endphp
    @break

    @default
        @php $class = 'text-blue-800 bg-white dark:bg-gray-900 dark:text-blue-400 border border-blue-300 dark:border-blue-800' @endphp
    @break
@endswitch

<div {{ $attributes->merge(['class' => "relative flex items-center p-4 my-2 mx-4 text-sm rounded-lg  $class"]) }} role="alert">
    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="currentColor" viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="font-bold">{{ $title }}</span>&nbsp;
    <div>
        {{ $slot }}
    </div>
    <button type="button" class="absolute top-0 right-0 px-3 py-2" onclick="closeMessage(this)">
        <svg class="w-4 h-4 text-gray-500 hover:text-gray-700" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
