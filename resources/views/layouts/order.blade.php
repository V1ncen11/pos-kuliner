<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Seblak Saiton — Pesan seblak favorit kamu langsung dari meja!">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seblak Saiton — Self Order')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>
