<?php
$role='kota';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kota/Kabupaten</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style_kakot.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/logo_selaksa.png" sizes="32x32">
</head>

<body class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <x-sidebar_kakot :role="$role"></x-sidebar_kakot>

    <main class="md:ml-48 flex-1 flex flex-col relative overflow-hidden">

        <!-- HEADER -->
        <x-header>{{ $title }}</x-header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto p-8 relative scrollbar-hide">

            <!-- STATUS CARD -->
            <x-statuscard_kakot :stat="$stat"></x-statuscard_kakot>

            <!-- TABLE -->
            {{ $slot }}
    </div>
    </main>

    <script src="{{ asset('js/dashboard_kakot.js') }}"></script>
</body>
</html>