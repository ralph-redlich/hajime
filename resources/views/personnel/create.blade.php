@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-600 text-gray-100 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                Add new {{ ucfirst($role) }}
            </header>

            <div class="w-full p-6">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul id="errors list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ action('App\Http\Controllers\PersonnelController@store') }}" role="form">
                    @csrf
                    <input type="hidden" name="club_id" value="{{ $club }}">
                    <input type="hidden" name="role" value="{{ $role }}">
                    <div class="w-full border-2 border-gray-300 rounded-xl p-8 mb-4">
                        <div class="mb-4">
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="name">
                                Full Name
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="name" name="name" type="text" placeholder="Name" required>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="phone">
                                Phone
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="phone" name="phone" type="text" placeholder="Phone">
                        </div>
                        <div>
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="email" name="email" type="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="w-full border-2 border-gray-300 rounded-xl p-8 flex flex-wrap">
                        <div class="w-full mb-8">
                            <span class="bg-gray-100 p-3 rounded text-gray-500 font-semibold text-sm">All fields in
                                this section are optional so make sure you fill in the correct ones for a specific role.
                            </span>
                        </div>
                        <div class="w-full md:w-1/2 sm:w-full">
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">Vetting information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="vetting_completion">
                                    Vetting completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="vetting_completion" name="vetting_completion" type="date"
                                       placeholder="2020-01-01">
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="vetting_expiry">
                                    Vetting expiry
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="vetting_expiry" name="vetting_expiry" type="date" placeholder="2020-01-01">
                            </div>
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6 mt-16">Safeguarding information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="safeguarding_completion">
                                    Safeguarding completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                id="safeguarding_completion" name="safeguarding_completion" type="date"
                                       placeholder="2020-01-01">
                            </div>
@include('partials.safeguarding-level-expiries', ['role' => $role])
                        </div>
                        <div class="w-full md:w-1/2 sm:w-full mt-16 md:mt-0">
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">First Aid information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="first_aid_completion">
                                    First Aid completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="first_aid_completion" name="first_aid_completion" type="date" placeholder="2020-01-01">
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="first_aid_expiry">
                                    First Aid expiry
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="first_aid_expiry" name="first_aid_expiry" type="date" placeholder="2020-01-01">
                            </div>
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6 mt-16">Coaching information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="coaching_completion">
                                    Coaching Qualification
                                </label>
                                <select name="coaching_qualification" id="coaching_qualification" class="shadow border-gray-300 rounded w-64 py-2 px-3 text-grey-darker">
                                    <option value="" disabled selected>Select level of qualifications</option>
                                    <option value="Level 1">Level 1</option>
                                    <option value="Level 2">Level 2</option>
                                    <option value="Level 3">Level 3</option>
                                    <option value="UKCC Level 1">UKCC Level 1</option>
                                    <option value="UKCC Level 2">UKCC Level 2</option>
                                    <option value="UKCC Level 3">UKCC Level 3</option>
                                    <option value="UKCC Level 4">UKCC Level 4</option>
                                    <option value="UKCC Level 5">UKCC Level 5</option>
                                </select>
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="coaching_expiry">
                                    Date attained
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="coaching_date" name="coaching_date" type="date" placeholder="2020-01-01">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <input type="submit" value="+ Add New {{ $role }}" class="button-judo">
                    </div>
                </form>
                <p class="text-gray-700 mt-6">

                </p>
            </div>
        </section>
    </div>
</main>
@endsection
