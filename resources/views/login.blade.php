<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <style>
      body {
      background-color: #f5f5f5
      }
    </style>
</head>
<body>
  
<div class="absolute top-6 left-8 z-10 flex items-start gap-3 text-black/80">
    <div class="flex flex-col">
    </div>
</div>

  <div class="relative z-10 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-lg">
    <img src="{{ asset('img/Logo_Selaksa.png' ) }}" class="h-15 w-auto"
        alt="Logo Selaksa" style="margin: 0 auto">
    <h2 class="text-center text-2xl font-semibold text-gray-700 mt-4">
      SELAKSA
    </h2>
    <p class="text-center font-normal text-gray-700" style="font-size: 13px ;">
            Transformasi Layanan dalam Satu Genggaman.
        </p>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="/dashboard" method="POST" class="space-y-6">
      <div>
        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
        <div class="mt-2">
          <input id="username" type="username" name="username" required autocomplete="username" placeholder="Email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-lime-400 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-lime-400 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-lime-400 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-lime-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-400">Login</button>
      </div>
    </form>

<div class="absolute bottom-4 text-xs text-black/80 opacity-80 z-10">
      © 2026 SELAKSA Team. Government Technology Excellence.
  </div>

</body>
</html>