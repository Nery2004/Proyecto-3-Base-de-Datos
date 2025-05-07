<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Biblioteca') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light text-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="{{ url('/reports') }}">Sistema de Gestión Bibliotecaria</a>
        </div>
    </nav>

    <main class="py-4 bg-dark" data-bs-theme="dark">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>