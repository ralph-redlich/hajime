<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Blocked -->
    <meta name="robots" content="noindex">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


    <title>{{ config('app.name', 'Hajime') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    @livewireStyles
    @filamentStyles


</head>
<body class="bg-gray-300 h-screen antialiased leading-none font-sans pb-12">
<div id="app" class="h-full pb-12">
    <header class="bg-judo-green py-3 shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/ija-logo.png') }}" alt="Irish Judo Logo" class="w-12 h-12 mr-1">
                    </a>
                </div>
                <div class="w-auto">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                </a>
            </div>
            <nav class="space-x-4 text-white text-sm sm:text-base font-semibold" x-data="{dropdown: false, settings: false}">
                <a class="no-underline hover:underline hover:text-orange-200" href="/">Home</a>
                @role('admin')
                <a class="no-underline hover:underline hover:text-orange-200"
                   href="{{ route('clubs.index') }}">Clubs</a>
                <a class="no-underline hover:underline hover:text-orange-200"
                   href="{{ route('member.index') }}">Members</a>
                <a class="no-underline hover:underline hover:text-orange-200" href="{{ route('club.access.users') }}">Users</a>
                <!-- Profile dropdown -->
                <div @click.away="dropdown = false" class="ml-3 relative inline-block font-semibold">
                    <div class="inline">
                        <button @click="dropdown = !dropdown" class="no-underline hover:underline
                        hover:text-orange-200 font-semibold" id="reports-menu"
                                aria-haspopup="true" x-bind:aria-expanded="dropdown">
                            <span class="sr-only">Open reports menu</span>
                            Reports <i class="fas fa-sort-down"></i>
                        </button>
                    </div>
                    <transition enter-active-class="transition ease-out duration-100" enter-class="transform
                    opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75" leave-class="transform
                                opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div x-show="dropdown" x-description="Profile dropdown panel, show/hide based on dropdown
                        state."
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white
                            ring-1 ring-black ring-opacity-5 z-50" role="menu" aria-orientation="vertical"
                             aria-labelledby="reports-menu">
                            <a href="{{ route('report.membership') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Memberships</a>
                            <a href="{{ route('report.club-members') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Club Members</a>
                            <a href="{{ route('report.club.status') }}" class="block px-4 py-2 text-sm text-gray-700
                            hover:bg-gray-100"
                               role="menuitem">Club Status</a>
                            <a href="{{ route('report.invalid.personnel') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Invalid Club Personnel</a>
                            <a href="{{ route('report.active.coaches') }}" class="block px-4 py-2 text-sm text-gray-700
                            hover:bg-gray-100"
                               role="menuitem">Active Coaches</a>
                            <a href="{{ route('report.email.consent') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Email Consent</a>
                            <a href="{{ route('report.grading.list') }}" class="block px-4 py-2 text-sm text-gray-700
                            hover:bg-gray-100"
                               role="menuitem">Grading List</a>
                            <a href="{{ route('report.compliance-status') }}" class="block px-4 py-2 text-sm text-gray-700
                            hover:bg-gray-100"
                               role="menuitem">Compliance Status</a>
                        </div>
                    </transition>
                </div>
                <div @click.away="settings = false" class="ml-3 relative inline-block font-semibold">
                    <div class="inline">
                        <button @click="settings = !settings" class="no-underline hover:underline
                        hover:text-orange-200 font-semibold" id="reports-menu"
                                aria-haspopup="true" x-bind:aria-expanded="dropdown">
                            <span class="sr-only">Open settings menu</span>
                            Settings <i class="fas fa-sort-down"></i>
                        </button>
                    </div>
                    <transition enter-active-class="transition ease-out duration-100" enter-class="transform
                    opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75" leave-class="transform
                                opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div x-show="settings" x-description="Profile dropdown panel, show/hide based on dropdown
                        state."
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white
                            ring-1 ring-black ring-opacity-5 z-50" role="menu" aria-orientation="vertical"
                             aria-labelledby="reports-menu">
                            <a href="{{ route('pages.logs-page') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Activity Log</a>
                            <a href="{{ route('pages.admin-list') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Admin Users</a>
                            <a href="{{ route('pages.options-page') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Options</a>
                            <a href="{{ route('members.checkMemberships') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Check memberships</a>
                            <a href="{{ route('pages.activation_codes') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem">Activation codes</a>

                        </div>
                    </transition>
                </div>
                @endrole
                @role('manager')
                <a class="no-underline hover:underline hover:text-orange-200" href="{{ route('club.access.club') }}">My
                    Club</a>
                @endrole
                @guest
                    <a class="no-underline hover:underline hover:text-orange-200"
                       href="{{ route('login') }}">{{ __('Login') }}</a>
                    {{--                    @if (Route::has('register'))--}}
                    {{--                        <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                    {{--                    @endif--}}
                @else
                    <a href="{{ route('logout') }}"
                       class="no-underline hover:underline"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    @yield('content')
</div>
@livewireScripts
@filamentScripts
@yield('bottomScripts')
</body>
</html>
