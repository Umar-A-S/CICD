<?php
$role='kota';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Data Kota/Kabupaten</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <x-sidebar :role="$role"></x-sidebar>
    <main class="flex-1 flex flex-col relative overflow-hidden">

        <!-- HEADER -->
        <x-header>{{ $title }}</x-header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto p-8 relative scrollbar-hide">

            <!-- ARSIP DATA -->
            {{ $slot }}

        </div>
    </main>

    <!-- SCRIPT -->
    <script src="js/scriptarsipkota.js"></script>

</body>
</html>