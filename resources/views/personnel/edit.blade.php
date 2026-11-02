@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-600 text-gray-100 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                Edit {{ $person->name }}
            </header>

            <div class="w-full p-6">
                <a href="{{ route('clubs.show', $person->club_id) }}#personnel" class="blue-pillow">< Back to Club
                    page</a>
                @if(Session::has('message'))
                    <p class="bg-green-100 text-green-700 p-6 rounded my-6">{{ Session::get('message') }}</p>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul id="errors list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ action('App\Http\Controllers\PersonnelController@update', $person->id)
                }}"
                      role="form">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <div class="w-full border-2 border-gray-300 rounded-xl p-8 my-4">
                        <div class="mb-4">
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="name">
                                Person's Name
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="name" name="name" type="text" value="{{ $person->name }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="phone">
                                Phone
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="phone" name="phone" type="text" value="{{ $person->phone }}">
                        </div>
                        <div>
                            <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                id="email" name="email" type="email" value="{{ $person->email }}">
                        </div>
                    </div>
                    <div class="w-full border-2 border-gray-300 rounded-xl p-8 flex flex-wrap">
                        <div class="w-full md:w-1/2 sm:w-full">
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">Vetting information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="vetting_completion">
                                    Vetting completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="vetting_completion" name="vetting_completion" type="date" value="{{
                                    $person->vetting_completion }}">
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="vetting_expiry">
                                    Vetting expiry
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="vetting_expiry" name="vetting_expiry" type="date" value="{{
                                    $person->vetting_expiry }}">
                            </div>
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6 mt-16">Safeguarding information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="safeguarding_completion">
                                    Safeguarding completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                id="safeguarding_completion" name="safeguarding_completion" type="date" value="{{
                                    $person->safeguarding_completion }}">
                            </div>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="safeguarding_expiry">
                                    Safeguarding expiry
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="safeguarding_expiry" name="safeguarding_expiry" type="date" value="{{
                                    $person->safeguarding_expiry }}">
                            </div>
                            @include('partials.safeguarding-level-expiries', ['record' => $person])
                        </div>
                        <div class="w-full md:w-1/2 sm:w-full mt-16 md:mt-0">
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">First Aid information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="first_aid_completion">
                                    First Aid completion
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="first_aid_completion" name="first_aid_completion" type="date" value="{{
                                    $person->first_aid_completion }}">
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="first_aid_expiry">
                                    First Aid expiry
                                </label>
                                <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                    id="first_aid_expiry" name="first_aid_expiry" type="date" value="{{
                                    $person->first_aid_expiry }}">
                            </div>
                            <h4 class="w-auto text-gray-500 text-xl font-bold mb-6 mt-16">Coaching information:</h4>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="coaching_completion">
                                    Coaching Qualification
                                </label>
                                <select name="coaching_qualification" id="coaching_qualification" class="shadow
                                border-gray-300 rounded w-64 py-2 px-3 text-grey-darker">
                                    @if ( $person->coaching_qualification)
                                    <option value="{{ $person->coaching_qualification }}" selected>{{ $person->coaching_qualification }}</option>
                                    @else
                                        <option value="" selected disabled>Select qualification level</option>
                                    @endif
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
                                    id="coaching_date" name="coaching_date" type="date" value="{{
                                    $person->coaching_date }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <input type="submit" value="Save changes" class="button-judo">
                    </div>
                </form>
                <p class="text-gray-700 mt-6">

                </p>
            </div>
        </section>
    </div>
</main>
@endsection
