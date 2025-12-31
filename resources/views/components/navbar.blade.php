<nav class="bg-gray-800" x-data="{ mobileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center">
                <div class="shrink-0">
                    <img
                        src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                        alt="Logo"
                        class="size-8"
                    />
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href="/" :active="request()->is('/')">Home Page</x-nav-link>
                        <x-nav-link href="/posts" :active="request()->is('posts')">Blog</x-nav-link>
                        <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
                        <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="flex rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <img
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                                class="size-10 rounded-full object-cover"
                                alt="Profile"
                            />
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 z-10 mt-2 w-48 rounded-md bg-white py-1 shadow-lg"
                        >
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Your profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Sign out
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Mobile button -->
            <div class="-mr-2 flex md:hidden">
                <buttont
                    @click="mobileOpen = !mobileOpen"
                    type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white"
                >
                    <svg
                        class="size-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

   <div
    x-show="mobileOpen"
    x-transition
    class="md:hidden"
>
    <!-- Menu links -->
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        <x-nav-link href="/" :active="request()->is('/')">Home Page</x-nav-link>
        <x-nav-link href="/posts" :active="request()->is('posts')">Blog</x-nav-link>
        <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
        <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
    </div>

    <!-- PROFILE (INI YANG KEMARIN KEHAPUS) -->
    <div class="border-t border-white/10 pt-4 pb-3">
        <div class="flex items-center px-5">
            <div class="shrink-0">
                <img
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                    class="size-10 rounded-full object-cover"
                    alt="Profile"
                />
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-white">Tom Cook</div>
                <div class="text-sm font-medium text-gray-400">tom@example.com</div>
            </div>
        </div>

        <div class="mt-3 space-y-1 px-2">
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                Your profile
            </a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                Settings
            </a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                Sign out
            </a>
        </div>
    </div>
  </div>

</nav>
