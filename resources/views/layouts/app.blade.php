<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Biblioteca') }}</title>

    {{-- Vite: CSS y JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light text-dark">
    {{-- Barra de navegación simple --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Biblioteca') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('reports.*') ? ' active' : '' }}" href="{{ route('reports.index') }}">Reportes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Carga scripts adicionales si los hay --}}
    @stack('scripts')
</body>
</html>