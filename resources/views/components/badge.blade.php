@php
$class = match ($color) {
    'gray' => 'bg-gray-200 text-gray-800',
    'red' => 'bg-red-200 text-red-800',
    'green' => 'bg-green-200 text-green-800',
    'yellow' => 'bg-yellow-200 text-yellow-800',
    'indigo' => 'bg-indigo-200 text-indigo-800',
    default => 'bg-blue-200 text-blue-800',
};
@endphp

<span class="{{ $class }} text-xs font-semibold mr-2 px-2 py-1 rounded">{{ $slot }}</span>
