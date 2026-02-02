<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style_prov.css">
    <link rel="icon" type="image/png" href="/img/logo_selaksa.png" sizes="32x32">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen overflow-hidden bg-gray-100">

    <!-- SIDEBAR -->
    <x-sidebar_kakot :role="$role"></x-sidebar_kakot>

    <main class="md:ml-48 flex-1 flex flex-col overflow-hidden bg-gray-100">

        <!-- HEADER -->
        <x-header_prov>{{ $title }}</x-header_prov>

        <!-- CONTENT -->
        <div class="flex-1 overflow-auto px-6 py-8 scrollbar-hide">

            <!-- PAGE CONTAINER -->
            <div class="max-w-7xl mx-auto space-y-8">

                <!-- PAGE CONTENT -->
                {{ $slot }}

            </div>
        </div>

    </main>

</body>
</html>
