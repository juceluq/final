@props([
    'type' => 'info',
    'title' => 'Info Alert!', // Valor predeterminado
])

@switch($type)
    @case('info')
        @php $class = 'text-blue-800 bg-white dark:bg-gray-900 dark:text-blue-400' @endphp
    @break

    @case('danger')
        @php $class = 'text-red-800 bg-white dark:bg-gray-900 dark:text-red-400' @endphp
    @break

    @case('success')
        @php $class = 'text-green-800 bg-white dark:bg-gray-900 dark:text-green-400' @endphp
    @break

    @case('warning')
        @php $class = 'text-yellow-800 bg-white dark:bg-gray-900 dark:text-yellow-400' @endphp
    @break

    @case('dark')
        @php $class = 'text-gray-800 bg-white dark:bg-gray-900 dark:text-gray-400' @endphp
    @break

    @default
        @php $class = 'text-blue-800 bg-white dark:bg-gray-900 dark:text-blue-400' @endphp
    @break
@endswitch

<div {{ $attributes->merge(['class' => "p-4 mb-4 text-sm rounded-lg $class"]) }} role="alert">
    <span class="font-medium">{{ $title }}</span> {{ $slot }}
</div>
