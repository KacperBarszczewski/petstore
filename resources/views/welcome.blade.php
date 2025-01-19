<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kacper Barszczewski</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>

        </style>
    @endif
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-600 min-h-screen flex flex-col">
    <header>
        <nav
            class="flex flex-row p-4 bg-gray-200 font-semibold  items-center justify-center  *:basis-1/3 *:flex *:items-center">
            <div class="justify-start">
                <a href="" class="hover:underline">Lista</a>
            </div>
            <div class="text-lg font-bold justify-center">
                <a href="https://github.com/KacperBarszczewski" target="_blank" rel="noopener noreferrer"
                    class="hover:underline">Kacper
                    Barszczewski</a>
            </div>
            <div class="justify-end">
                <a href="" class="hover:underline">Dodaj zwierzaka</a>
            </div>

        </nav>
    </header>

    <div class="flex-grow flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold text-gray-800">Welcome to Laravel</h1>
        <p class="text-lg mt-4">This is a Laravel application with Vite.js</p>
    </div>

    <footer class="p-4 bg-gray-200 font-semibold text-center">
        <a href="https://github.com/KacperBarszczewski" target="_blank" rel="noopener noreferrer">
            &copy; Kacper Barszczewski
        </a>
    </footer>

</body>

</html>