<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Siamawolu Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gray-200 px-6">
        <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
