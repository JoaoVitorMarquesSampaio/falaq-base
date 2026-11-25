@props(['type' => 'submit'])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center bg-red-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors'
    ]) }}
>
    {{ $slot }}
</button>
