<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Home</title>
    
</head>

<body class="h-full">
<div class="min-h-full" x-data="{ mobileOpen: false }">

<x-navbar></x-navbar>

<x-header>{{ $title }}</x-header>
<!-- MAIN -->
<main>
    <div class="mx-auto max-w-7xl px-4 py-6">
        {{ $slot }}
    </div>
</main>


</div>
</body>
</html>
