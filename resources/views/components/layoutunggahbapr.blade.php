<?php
$role='kota';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UNGGAH BAPR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex h-screen overflow-hidden">

    <main class="flex-1 flex flex-col relative overflow-hidden">

        <!-- HEADER -->
        <x-header>{{ $title }}</x-header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto p-8 relative scrollbar-hide">

            <!-- TABLE -->
            {{ $slot }}
    </div>
    </main>

    <!-- SCRIPT -->
    <script src="{{ asset('js/unggahbapr.js') }}"></script>

</body>
</html>