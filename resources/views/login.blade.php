<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SELAKSA</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-100 flex flex-col items-center justify-center text-gray-800">

    <!-- CARD -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl px-8 py-10">

        <!-- LOGO -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('img/logo_selaksa.png') }}"
                alt="SELAKSA"
                class="h-16">
        </div>

        <!-- TITLE -->
        <h2 class="text-center text-2xl font-bold tracking-wide">
            SELAKSA
        </h2>

        <p class="text-center text-sm text-gray-500 mt-1 mb-8">
            Transformasi Layanan dalam Satu Genggaman.
        </p>

        <!-- FORM -->
        <form action="/login" method="POST" class="space-y-6">
            @csrf
            <!-- USERNAME -->
            <div>
                <label class="block text-sm font-semibold mb-1">
                    Username
                </label>
                <input 
                    name="username"
                    id="username"
                    type="text"
                    placeholder="Username"
                    value="{{ old('username') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">
                @error('username')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-semibold mb-1">
                    Password
                </label>
                <input
                    name="password"
                    id="password" 
                    type="password"
                      placeholder="Password"
                      class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400">

                <!-- LUPA PASSWORD -->
                <div class="mt-2 text-right">
                    <a href="javascript:void(0)"
                      onclick="lupaPasswordWA()"
                      class="text-xs font-medium text-lime-500 hover:underline">
                        Lupa password?
                    </a>
                </div>
            </div>

            <!-- BUTTON -->
            <button 
            type="submit" 
            class="w-full mt-6 rounded-xl bg-lime-400 py-2.5 text-white text-sm font-bold hover:bg-lime-500 transition duration-200 shadow-md"> LOGIN
            </button>

        </form>
    </div>

    <!-- FOOTER -->
    <p class="mt-8 text-xs text-gray-500">
        © 2026 SELAKSA Team. Government Technology Excellence.
    </p>

    <!-- SCRIPT -->
    <script src="js/login.js"></script>

</body>
</html>