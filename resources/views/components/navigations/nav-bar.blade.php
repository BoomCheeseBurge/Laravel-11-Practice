<nav class="py-3 bg-slate-200 dark:bg-slate-800">
    <div class="mx-auto max-w-7xl px-4 lg:px-8 sm:px-6">
        <div class="h-16 flex justify-between items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="w-14 h-10 rounded-lg" src="{{ asset('IMG/logo/book-logo-2.jpg') }}" alt="Logo">
                </div>
                <div class="hidden md:block">
                    <div class="flex items-baseline ml-10 space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <x-navigations.nav-link href="/" :active="request()->is('/')" class="text-sm">Home</x-navigations.nav-link>
                        <x-navigations.nav-link href="/about" :active="request()->is('about')" class="text-sm">About</x-navigations.nav-link>
                        <x-navigations.nav-link href="/posts" :active="request()->is('posts')" class="text-sm">Blog</x-navigations.nav-link>
                        <x-navigations.nav-link href="/contact" :active="request()->is('contact')" class="text-sm">Contact</x-navigations.nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center">
                    <!-- Dark Mode Toggler -->
                    <x-ui.toggle-dark-mode></x-ui.toggle-dark-mode>
                    <!-- Dark Mode Toggler -->

                    <div class="relative ml-12">
                        @auth
                        <!-- ------------------------------------------------------ Profile dropdown ------------------------------------------------------ -->
                        <div class="flex items-center">
                            <span class="text-boxdark-2 mr-3 text-base font-medium tracking-wider dark:text-white">{{ auth()->user()->username }}</span>
                            <button type="button" x-on:click="isOpen = !isOpen" x-on:click.outside="isOpen = false"
                            class="max-w-xs relative flex items-center text-sm rounded-full focus:ring-offset-primary-600 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="-inset-1.5 absolute"></span>
                                <span class="sr-only">Open user menu</span>
                                @if (auth()->user()->profile_pic)
                                <img src="{{ Storage::disk('profile')->url(auth()->user()->profile_pic) }}" alt="{{ auth()->user()->username }} Profile Picture" class="w-10 h-10 rounded-full md:w-12 md:h-12">
                                @else
                                <div class="text-primary-500 p-3 text-lg font-semibold tracking-widest bg-slate-100 rounded-full border border-slate-300 dark:border-none">
                                {{ strtoupper(implode('', array_map(fn($n) => $n[0], array_slice(explode(' ', auth()->user()->fullname), 0, 2)))); }}
                                </div>
                                @endif
                            </button>
                        </div>

                        <!--
                        Dropdown menu, show/hide based on menu state.

                        Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div x-show="isOpen"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="ring-opacity-5 w-48 absolute right-0 z-10 py-1 mt-2 text-gray-700 bg-white rounded-md ring-1 ring-black shadow-lg origin-top-right dark:text-white dark:bg-gray-800 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="{{ route('dashboard.kanban') }}" class="flex items-center gap-2 px-4 py-3 text-sm border-b border-slate-300 dark:hover:text-boxdark-2 hover:bg-slate-100" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z"/>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('user.profile', ['user' => auth()->user()->username]) }}" class="flex items-center gap-2 px-4 py-3 text-sm border-b border-slate-300 dark:hover:text-boxdark-2 hover:bg-slate-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                Profile
                            </a>
                            <a href="{{ route('user.setting', ['user' => auth()->user()->username]) }}" class="flex items-center gap-2 px-4 py-3 text-sm border-b border-slate-300 dark:hover:text-boxdark-2 hover:bg-slate-100" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                </svg>
                                Settings
                            </a>
                            <form action="{{ route('login.out') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-sm dark:hover:text-boxdark-2 hover:bg-slate-100" role="menuitem" tabindex="-1" id="user-menu-item-3">
                                    Sign out
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @else
                        <!-- ------------------------------------------------------ Login Link ------------------------------------------------------ -->
                        <a href="/login" class="relative flex items-center text-base font-medium tracking-wider text-teal-500 group dark:text-sky-200">
                            <svg class="right-15 w-5 h-5 absolute bottom-1 group-hover:animate-bounce_right" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="right-arrow-bg" stroke-width="0"></g><g id="right-arrow-tracer" stroke-linecap="round" stroke-linejoin="round"></g><g id="right-arrow-icon"> <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="right-bracket-bg" stroke-width="0"></g><g id="right-bracket-tracer" stroke-linecap="round" stroke-linejoin="round"></g><g id="right-bracket-icon"> <path d="M10 21H14L14 3H10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            Login
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex items-center gap-12 md:hidden">
                <!-- Mobile menu button -->
                <button type="button" x-on:click="isOpen = !isOpen"
                class="relative inline-flex justify-center items-center p-2 text-gray-200 bg-indigo-800 rounded-md dark:text-boxdark-2 dark:bg-slate-200 dark:focus:ring-offset-slate-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-800" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="-inset-0.5 absolute"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg x-bind:class="{'hidden': isOpen, 'block': !isOpen }" class="w-6 h-6 block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg x-bind:class="{'block': isOpen, 'hidden': !isOpen }" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-3 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <x-navigations.nav-link href="/" :active="request()->is('/')" class="block text-base">Home</x-navigations.nav-link>
            <x-navigations.nav-link href="/about" :active="request()->is('about')" class="block text-base">About</x-navigations.nav-link>
            <x-navigations.nav-link href="/posts" :active="request()->is('posts')" class="block text-base">Blog</x-navigations.nav-link>
            <x-navigations.nav-link href="/contact" :active="request()->is('contact')" class="block text-base">Contact</x-navigations.nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
            @auth
            <div class="flex justify-between pr-8">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        @if (auth()->user()->profile_pic)
                        <img src="{{ Storage::disk('profile')->url(auth()->user()->profile_pic) }}" alt="{{ auth()->user()->username }} Profile Picture" class="h-15 w-15 rounded-full">
                        @else
                        <div class="text-primary-500 p-3 text-lg font-semibold tracking-widest bg-slate-100 rounded-full border border-slate-300 dark:border-none">
                        {{ strtoupper(implode('', array_map(fn($n) => $n[0], array_slice(explode(' ', auth()->user()->fullname), 0, 2)))); }}
                        </div>
                        @endif
                    </div>
                    <div class="ml-3 space-y-1">
                        <div class="text-boxdark-2 text-base font-medium tracking-widest leading-none dark:text-white">{{ auth()->user()->username }}</div>
                        <div class="text-primary-500 block text-sm font-bold tracking-wider dark:font-normal dark:text-slate-200">
                            @if (auth()->user()->is_admin)
                            Admin
                            @else
                            User
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Dark Mode Toggler -->
                <x-ui.toggle-dark-mode></x-ui.toggle-dark-mode>
                <!-- Dark Mode Toggler -->
            </div>
            <div class="px-2 mt-3 space-y-3">
                <a href="{{ route('dashboard.kanban') }}" class="text-primary-600 block px-3 py-2 text-base font-medium rounded-md dark:text-slate-200 dark:hover:bg-gray-600 hover:text-primary-800 hover:bg-slate-300">Dashboard</a>
                <a href="{{ route('user.profile', ['user' => auth()->user()->username]) }}" class="text-primary-600 block px-3 py-2 text-base font-medium rounded-md dark:text-slate-200 dark:hover:bg-gray-600 hover:text-primary-800 hover:bg-slate-300">Your Profile</a>
                <a href="{{ route('user.setting', ['user' => auth()->user()->username]) }}" class="text-primary-600 block px-3 py-2 text-base font-medium rounded-md dark:text-slate-200 dark:hover:bg-gray-600 hover:text-primary-800 hover:bg-slate-300">Settings</a>
                <form action="{{ route('login.out') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full block px-3 py-2 text-base font-medium text-slate-600 rounded-md group dark:text-slate-300 dark:hover:text-slate-100 dark:hover:bg-slate-600 hover:text-boxdark-2 hover:bg-gray-300" role="menuitem" tabindex="-1" id="user-menu-item-3">
                        Sign out
                        <svg class="w-6 h-6 inline text-gray-500 dark:text-white dark:group-hover:text-whiter group-hover:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                        </svg>
                    </button>
                </form>
            </div>
            @else
            <div class="flex justify-center">
                <!-- Dark Mode Toggler -->
                <x-ui.toggle-dark-mode></x-ui.toggle-dark-mode>
                <!-- Dark Mode Toggler -->
            </div>
            <div class="px-2 mt-6 space-y-1 group">
                <a href="/login" class="flex justify-center items-center px-3 py-2 text-base font-medium tracking-wider text-gray-500 rounded-md hover:text-white hover:bg-gray-600">
                    <svg class="-mr-1.5 -mt-1 w-5 h-5 group-hover:animate-bounce_right" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="right-arrow-bg" stroke-width="0"></g><g id="right-arrow-tracer" stroke-linecap="round" stroke-linejoin="round"></g><g id="right-arrow-icon"> <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="right-bracket-bg" stroke-width="0"></g><g id="right-bracket-tracer" stroke-linecap="round" stroke-linejoin="round"></g><g id="right-bracket-icon"> <path d="M10 21H14L14 3H10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    Login
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>
