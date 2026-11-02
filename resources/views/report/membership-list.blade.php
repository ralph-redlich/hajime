@extends('layouts.app')

@section('content')
    <div style="min-height: 640px;" class="bg-gray-100">

        <div class="h-screen flex overflow-hidden bg-gray-100" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">

            <!-- Static sidebar for desktop -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="flex flex-col h-0 flex-1">
                        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                            <svg class="text-gray-400 mr-3 h-6 w-6" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-2xl text-gray-300 font-bold">Reports</span>
                        </div>
                        <div class="flex-1 flex flex-col overflow-y-auto">
                            <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">


                                <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                                <a href="{{ route('report.membership') }}" class="bg-gray-900 text-white hover:bg-gray-700
                                hover:text-white group flex
                                items-center
                                px-2 py-2
                                text-sm
                                font-bold rounded-md">
                                    <!-- Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300" -->
                                    Membership List
                                </a>

                                <a href="{{ route('report.club-members') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Club Member List
                                </a>

                                <a href="{{ route('report.club.status') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white
                                group
                                 flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Clubs Status
                                </a>

                                <a href="{{ route('report.invalid.personnel') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Invalid Club Personnel
                                </a>

                                <a href="{{ route('report.active.coaches') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white
                                group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Active Coaches
                                </a>
                                <a href="{{ route('report.email.consent') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Email Consent
                                </a>

                                <a href="{{ route('report.grading.list') }}" class="text-gray-300
                                hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Grading List
                                </a>

                                <a href="{{ route('report.compliance-status') }}" class="text-gray-300
                                hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Compliance Status
                                </a>



                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow item">
                    <button @click.stop="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/menu-alt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <div class="text-2xl font-bold text-gray-700 pl-8 flex items-center">
                        <h2>Membership List</h2>
                    </div>
                </div>

                <main class="flex-1 relative overflow-y-auto focus:outline-none p-6" tabindex="0" x-data="" x-init="$el
                .focus()">
                    <div class="flex items-end w-full bg-white border-2
                    border-gray-200 justify-between rounded-xl p-4">
                        <form method="POST" action="" role="form" class="flex items-end">
                            @csrf
                            <div>
                                <label for="join_date" class="block text-sm text-gray-400 mb-2 font-bold">Start date</label>
                                @error('start_date')
                                <div class="text-red-600 text-sm"> {{ $message }}</div>
                                @enderror
                                <input type="date" name="start_date" id="start_date"
                                       class="shadow border-gray-300 rounded w-64 py-2 px-3
                                               text-grey-darker mr-2" required
                                       @isset($start_date)
                                        value={{ $start_date }}
                                       @endisset
                                    value={{ old('start_date') }}
                                >
                            </div>
                            <div class="ml-12">
                                <label for="join_date" class="block text-sm text-gray-400 mb-2 font-bold">End date</label>
                                @error('end_date')
                                    <div class="text-red-600 text-sm"> {{ $message }}</div>
                                @enderror
                                <input type="date" name="end_date" id="end_date"
                                       class="shadow border-gray-300 rounded w-64 py-2 px-3
                                               text-grey-darker mr-2
                                               @error('end_date') border-red-600 @enderror
                                        " required
                                       @isset($end_date)
                                       value={{ $end_date }}
                                    @endisset
                                           value={{ old('end_date') }}>

                            </div>
                            <div class="pb-1 ml-12">
                                <input type="submit" value="Submit" class="button-judo">
                            </div>
                        </form>
                        @if(isset($memberships) && !empty($memberships))
                                <a href="{{ route('report.membership.export', [$start_date, $end_date]) }}"
                                   class="button-judo">Export to
                                    Excel</a>
                        @endif
                    </div>

                    <div class="w-full mt-8">
                        @if(isset($memberships) && !empty($memberships))
                            <span class="text-gray-600 text-sm bg-gray-200 px-2 py-1 rounded">{{ $memberships->count()
                             }} results found </span>
                        @endif

                        <table class="min-w-full table-auto leading-normal mt-8">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 rounded-l bg-gray-600 text-left
                                            text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    No
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Name
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Gender
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Type
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Join Date
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Source
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Club
                                </th>

                                <th
                                    class="px-5 py-3 rounded-r bg-gray-600 text-left text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Province
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @isset ($memberships)
                                @each('report.membership-query-list', $memberships, 'membership', 'report.empty-form')
                            @else
                                <td colspan="8">
                                    <h4 class="text-xl text-gray-400 my-8 text-center">Please select 2 dates at the
                                        top first. <br/>For the sake of speed this report will display the first 100
                                        results only.
                                    </h4>
                                </td>
                            @endisset
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

    </div>


@endsection
