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
                <a href="{{route('pets.index')}}" class="hover:underline">Lista</a>
            </div>
            <div class="text-lg font-bold justify-center">
                <a href="https://github.com/KacperBarszczewski" target="_blank" rel="noopener noreferrer"
                    class="hover:underline">
                    Kacper Barszczewski
                </a>
            </div>
            <div class="justify-end">
                <a href="{{route('pets.create')}}"
                    class="hover:underline rounded-full bg-green-300 p-3 hover:bg-green-400">Dodaj zwierzaka</a>
            </div>

        </nav>
    </header>

    <div class="flex-grow flex flex-col items-center justify-center">
        @if (session('success'))
            <div id="alert" class="my-4 p-4 text-sm text-white bg-green-500 rounded-lg shadow-md transition-opacity duration-500 fixed top-0 left-1/4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert" class="my-4 p-4 text-sm text-white bg-red-500 rounded-lg shadow-md transition-opacity duration-500">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="p-4 bg-gray-200 font-semibold text-center">
        <a href="https://github.com/KacperBarszczewski" target="_blank" rel="noopener noreferrer">
            &copy; Kacper Barszczewski
        </a>
    </footer>

</body>

</html>