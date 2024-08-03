<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Battleship Online</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('stylesheets')
</head>
<body>
    <main id="app">
        @yield('app')
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('javascripts')
</body>
</html>
