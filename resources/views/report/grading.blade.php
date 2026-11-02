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
                                <a href="{{ route('report.membership') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white group flex items-center
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

                                <a href="{{ route('report.grading.list') }}" class="bg-gray-900 text-white
                                hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Grading List
                                </a>

                                <a href="{{ route('report.compliance-status') }}" class="text-gray-300 hover:bg-gray-700
                                hover:text-white group
                                flex
                                items-center px-2 py-2 text-sm font-bold rounded-md">
                                    Compliance status
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
                        <h2>Grading List</h2>
                    </div>
                </div>

                <main class="flex-1 relative overflow-y-auto focus:outline-none p-6" tabindex="0" x-data="" x-init="$el
                .focus()">
                    <div class="mb-6">
                        <form method="GET" action="" role="form">
                            <div class="w-full flex-none md:flex">
                                <div class="w-full md:w-1/2 lg:w-1/4">
                                    <label for="club" class="block text-sm text-gray-400 mb-2 font-bold">Club</label>
                                    @error('start_date')
                                    <div class="text-red-600 text-sm"> {{ $message }}</div>
                                    @enderror
                                    <select name="club" id="club" class="shadow border-gray-300 rounded w-full py-2 px-3
                                                            text-grey-darker">
                                        <option value="" selected>All Clubs
                                        </option>
                                        <option value="" disabled>----</option>
                                        @foreach( $clubs as $club)
                                            <option value="{{ $club->id }}"
                                                    @if (isset($selectedClub) && ($selectedClub == $club->id))
                                                        selected
                                                @endif
                                            >
                                                {{ $club->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:ml-4 w-full md:w-1/2 lg:w-1/4">
                                    <label for="gender" class="block text-sm text-gray-400 mb-2 font-bold">Gender</label>
                                    <select name="gender" id="gender" class="shadow border-gray-300 rounded w-full py-2
                                    px-3 text-grey-darker">
                                        <option value="" selected>All Genders</option>
                                        @foreach($genders as $gender)
                                            <option value="{{ $gender->short }}" @if(request()->get('gender') == '{{ $gender->short }}')
                                                selected @endif>{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:ml-4 w-full md:w-1/2 lg:w-1/4">
                                    <label for="gender" class="block text-sm text-gray-400 mb-2
                                                            font-bold">Membership Type</label>
                                    <select name="membership" id="membership" class="shadow border-gray-300 rounded
                                    w-full py-2 px-3 text-grey-darker">
                                        <option value="" selected>All Memberships</option>
                                        <option value="Under 12 – Junior Membership" @if(request()->get('membership')
                                         ==
                                        'Under 12 – Junior Membership')
                                            selected @endif>Under 12 – Junior
                                            Membership
                                        </option>
                                        <option value="Under 18 – Youth Membership" @if(request()->get('membership') ==
                                        'Under 18 – Youth Membership')
                                            selected @endif>Under 18 – Youth
                                            Membership
                                        </option>
                                        <option value="Over 18 – Adult Membership" @if(request()->get('membership') ==
                                        'Over 18 – Adult Membership')
                                            selected @endif>Over 18 – Adult Membership
                                        </option>
                                        <option value="Student Membership" @if(request()->get('membership') == 'Student
                                        Membership')
                                            selected @endif>Student Membership
                                        </option>
                                        <option value="Life Membership" @if(request()->get('membership') == 'Life
                                        Membership')
                                            selected @endif>Life Membership
                                        </option>
                                    </select>
                                </div>
                                <div class="md:ml-4 w-full md:w-1/2 lg:w-1/4">
                                    <label for="gender" class="block text-sm text-gray-400 mb-2 font-bold">Current
                                        Grade</label>
                                    <select name="grade" id="grade" class="shadow border-gray-300 rounded w-full py-2
                                    px-3
                                                            text-grey-darker">
                                        <option value="" selected>All Grades</option>
                                        @if(request()->get('grade'))
                                            <optgroup label="Currently Selected">
                                                <option value="{{ request()->get('grade') }}" selected> {{ request()
                                                ->get
                                                ('grade') }}
                                                </option>
                                            </optgroup>
                                        @endif
                                        <optgroup label="Junior Grades">
                                            <option value="1st Mon White">1st Mon White</option>
                                            <option value="2nd Mon Red">2nd Mon Red</option>
                                            <option value="3rd Mon White/Yellow">3rd Mon White/Yellow</option>
                                            <option value="4th Mon Yellow">4th Mon Yellow</option>
                                            <option value="5th Mon Yellow/Orange">5th Mon Yellow/Orange</option>
                                            <option value="6th Mon Orange">6th Mon Orange</option>
                                            <option value="7th Mon Orange/Green">7th Mon Orange/Green</option>
                                            <option value="8th Mon Green">8th Mon Green</option>
                                            <option value="9th Mon Green/Blue">9th Mon Green/Blue</option>
                                            <option value="10th Mon Blue">10th Mon Blue</option>
                                            <option value="11th Mon Blue/Brown">11th Mon Blue/Brown</option>
                                            <option value="12th Mon Brown">12th Mon Brown</option>
                                        </optgroup>
                                        <optgroup label="Senior Grades">
                                            <option value="6th Kyu White">6th Kyu White</option>
                                            <option value="5th Kyu Yellow">5th Kyu Yellow</option>
                                            <option value="4th Kyu Orange">4th Kyu Orange</option>
                                            <option value="3rd Kyu Green">3rd Kyu Green</option>
                                            <option value="2nd Kyu Blue">2nd Kyu Blue</option>
                                            <option value="1st Kyu Brown">1st Kyu Brown</option>
                                        </optgroup>
                                        <optgroup label="Dan Grades">
                                            <option value="1st Dan">1st Dan</option>
                                            <option value="2nd Dan">2nd Dan</option>
                                            <option value="3rd Dan">3rd Dan</option>
                                            <option value="4th Dan">4th Dan</option>
                                            <option value="5th Dan">5th Dan</option>
                                            <option value="6th Dan">6th Dan</option>
                                            <option value="7th Dan">7th Dan</option>
                                            <option value="8th Dan">8th Dan</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full mt-4">
                                <div>
                                    <input type="submit" value="Submit" class="button-judo bg-blue-800
                                    hover:bg-blue-500">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mb-6">
                        @if ($members->count() != 0)
                            <a href="{{ route('report.grading.export', request()->query()) }}"
                               class="button-judo"><i class="far fa-file-excel mr-2"></i> Export to Excel</a>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600">
                        @if ($members->count() >= 1)
                            Showing {{ $members->count() }} {{ Str::plural('result', $members->count()) }}
                        @endif
                    </div>
                    <div class="w-full">
                        <table class="min-w-full table-auto leading-normal mt-8">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 rounded-l bg-gray-600 text-left
                                            text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Number
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left text-xs
                                            font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Name
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Club
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Gender
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Membership
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                                            text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Current Grade
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($members as $member)
                                <tr>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->number }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->club->name }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->gender }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->currentMembership->membership_type }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $member->currentGrade->grade_level }}
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="text-gray-600 text-center text-xl mt-4">No members found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

    </div>

@endsection
