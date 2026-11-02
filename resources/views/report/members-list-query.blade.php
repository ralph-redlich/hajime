@extends('layouts.app')

@section('content')
    <div style="min-height: 640px;" class="bg-gray-100">

        <div class="h-screen flex overflow-hidden bg-gray-100" x-data="{ sidebarOpen: false }"
             @keydown.window.escape="sidebarOpen = false">

            <!-- Static sidebar for desktop -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="flex flex-col h-0 flex-1">
                        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                            <svg class="text-gray-400 mr-3 h-6 w-6" x-description="Heroicon name: outline/chart-bar"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
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

                                <a href="{{ route('report.club-members') }}" class="bg-gray-900 text-white
                                hover:bg-gray-700
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
                    <button @click.stop="sidebarOpen = true"
                            class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/menu-alt-2"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <div class="text-2xl font-bold text-gray-700 pl-8 flex items-center">
                        <h2>Club Members Report</h2>
                    </div>
                </div>

                <main class="flex-1 relative overflow-y-auto focus:outline-none p-6" tabindex="0" x-data="" x-init="$el
                .focus()">
                    <div class="flex items-end w-full bg-white border-2
                    border-gray-200 justify-between rounded-xl p-4">
                        <form method="POST" action="" role="form" class="w-full flex flex-wrap items-end justify-between">
                            @csrf
                            <div class="flex flex-wrap items-end gap-x-2 lg:gap-x-4">
                                <div class="mt-4 lg:mt-0">
                                    <label for="join_date" class="block text-sm text-gray-400 mb-2 font-bold">Start
                                        date</label>
                                    @error('start_date')
                                    <div class="text-red-600 text-sm"> {{ $message }}</div>
                                    @enderror
                                    <input type="date" name="start_date" id="start_date"
                                           class="shadow border-gray-300 rounded w-48 py-2 px-3
                                                                           text-grey-darker" required
                                           @isset($start_date)
                                               value={{ $start_date }}
                                                                   @endisset
                                                                       value={{ old('start_date') }}
                                        @disabled($flag == true)
                                    >
                                    @ray($flag)
                                </div>
                                <div class="mt-4 lg:mt-0">
                                    <label for="join_date" class="block text-sm text-gray-400 mb-2 font-bold">End
                                        date</label>
                                    @error('end_date')
                                    <div class="text-red-600 text-sm"> {{ $message }}</div>
                                    @enderror
                                    <input type="date" name="end_date" id="end_date"
                                           class="shadow border-gray-300 rounded
                                           w-48 py-2 px-3 text-grey-darker
                                           @error('end_date') border-red-600 @enderror"
                                           required
                                           @isset($end_date)
                                               value={{ $end_date }}
                                           @endisset
                                           value={{ old('end_date') }}
                                           @disabled($flag == true)>
                                </div>
                                <div class="mt-8 lg:mt-0">
                                    @error('club_id')
                                    <div class="text-red-600 text-sm"> {{ $message }}</div>
                                    @enderror
                                    <select name="club_id" id="club_id"
                                            class="shadow border-gray-300 rounded w-auto py-2 px-3 text-grey-darker"
                                    required>
                                        <option value="" disabled selected>Select Club</option>
                                        @foreach ($clubs as $club)
                                            <option value="{{ $club->id }}"
                                                    @if (isset($selectedClub) and $selectedClub->id == $club->id)
                                                        selected
                                                @endif>
                                                {{ $club->name}}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 mt-4 xl:mt-0 flex items-center">
                                    <input type="checkbox" id="inactive_members" name="inactive_members"
                                           class="shadow border-gray-300 rounded text-grey-darker mr-2" @checked($flag)>
                                    <label for="inactive_members" class="text-sm text-gray-400 font-bold block">Include
                                        inactive members</label>
                                </div>
                            </div>
                            <div class="mt-4 lg:mt-0">
                                <input type="submit" value="Submit" class="button-judo px-6 rounded-lg block">
                            </div>
                        </form>

                    </div>

                    <div class="w-full mt-4">
                        @isset($members)
                            <div class="mb-4">
                                <span class="text-gray-600 text-sm bg-gray-200 px-2 py-1 rounded">
                                    {{ $memberships->count() }} results found </span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <div class="text-xl font-bold text-gray-600">
                                @if (isset($selectedClub))
                                    <h2>Members of {{ $selectedClub->name }}</h2>
                                @endif
                            </div>
                            <div>
                                @if (isset($selectedClub) && !$flag)
                                    <a href="{{ route('report.members.export', [$selectedClub->id, $start_date, $end_date]) }}"
                                       class="button-judo">Export to Excel</a>
                                @elseif (isset($selectedClub))
                                    <a href="{{ route('report.members.export.all', [$selectedClub->id]) }}"
                                       class="button-judo">Export All</a>
                                @endif
                            </div>

                        </div>
                        <table class="min-w-full table-auto leading-normal mt-4">
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
                                    Memb. Type
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left
                    text-xs font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Join Date
                                </th>
                                <th
                                    class="px-5 py-3 bg-gray-600 text-left text-xs
                    font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Club
                                </th>

                                <th
                                    class="px-5 py-3 rounded-r bg-gray-600 text-left text-xs
                    font-semibold text-gray-100 uppercase tracking-wider shadow-lg">
                                    Grading
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @isset($members)
                                @foreach($members as $member)
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
                                                {{ $member->gender }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $member->latestMembership()->membership_type ?? 'None' }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $member->latestMembership()->join_date ?? 'None' }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $member->club->name }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 border-b border-gray-200 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $member->latestGrade()->grade_level ?? 'No grade' }}
                                            </p>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <td colspan="8">
                                    <h4 class="text-xl text-gray-400 my-8 text-center">Please make a selection at the
                                        top first. <br />For the sake of speed this report will display the first 100
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

@section('bottomScripts')
    <script>
        let inactive = document.getElementById("inactive_members");
        const date = new Date().toISOString().slice(0, 10);
        var year = new Date().getFullYear();
        var start_date = document.getElementById("start_date");

        window.onload = function() {
            if (inactive.checked) {
                document.getElementById("start_date").disabled = true;
                document.getElementById("start_date").required = false;
                document.getElementById("start_date").value = year + "-01-01";
                document.getElementById("start_date").classList.add("bg-gray-200");
                document.getElementById("end_date").disabled = true;
                document.getElementById("end_date").required = false;
                document.getElementById("end_date").value = year + "-12-31";
                document.getElementById("end_date").classList.add("bg-gray-200");
            }
        }

        inactive.addEventListener("change", function() {
            if (inactive.checked) {
                document.getElementById("start_date").disabled = true;
                document.getElementById("start_date").required = false;
                document.getElementById("start_date").value = year + "-01-01";
                document.getElementById("start_date").classList.add("bg-gray-200");
                document.getElementById("end_date").disabled = true;
                document.getElementById("end_date").required = false;
                document.getElementById("end_date").value = year + "-12-31";
                document.getElementById("end_date").classList.add("bg-gray-200");
            } else {
                document.getElementById("start_date").disabled = false;
                document.getElementById("start_date").required = true;
                document.getElementById("start_date").value = "";
                document.getElementById("start_date").classList.remove("bg-gray-200");
                document.getElementById("end_date").disabled = false;
                document.getElementById("end_date").required = true;
                document.getElementById("end_date").value = "";
                document.getElementById("end_date").classList.remove("bg-gray-200");
            }
        });


    </script>
@endsection
