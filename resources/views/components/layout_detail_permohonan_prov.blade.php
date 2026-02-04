<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permohonan Provinsi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD:resources/views/components/layout_detail_penerbitan_prov.blade.php

=======
    <link rel="stylesheet" href="css/style_prov.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/logo_selaksa.png" sizes="32x32">
>>>>>>> origin/superadmin:resources/views/components/layout_detail_permohonan_prov.blade.php
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen overflow-hidden">

    <main class="flex-1 flex flex-col relative overflow-hidden">

        <!-- HEADER -->
        <x-header_prov>{{ $title }}</x-header_prov>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto p-8 relative scrollbar-hide">

            <!-- TABLE -->
            {{ $slot }}
    </div>
    </main>

    <!-- SCRIPT -->
    <script src="{{ asset('js/detail_permohonan_prov.js') }}"></script>

</body>
</html>