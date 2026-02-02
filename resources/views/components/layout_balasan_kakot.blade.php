<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Kota / Kabupaten</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/logo_selaksa.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen bg-gray-100 overflow-hidden">

    <!-- SIDEBAR -->
    <x-sidebar_kakot :role="$role" />

    <!-- MAIN -->
    <main class="md:ml-48 flex-1 flex flex-col relative overflow-hidden">

        <!-- HEADER -->
        <x-header>{{ $title }}</x-header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto p-8">
            {{ $slot }}
        </div>
    </main>

    {{-- <!-- JS -->
    <script src="/js/balasan_kakot.js"></script> --}}
</body>
</html>