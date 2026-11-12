@extends('layouts.app')

@section('content')
    <main class="sm:container sm:mx-auto sm:mt-10">
        <div class="w-full sm:px-6">

            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                <header class="font-semibold bg-gray-600 text-gray-100 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    Edit {{ $volunteer->name }}
                </header>

                <div class="w-full p-6">
                    <a href="{{ route('clubs.show', $volunteer->club_id) }}#volunteers" class="blue-pillow">
                        < Back to Club page</a>
                    @if(Session::has('message'))
                        <p class="bg-green-100 text-green-700 p-6 rounded my-4">{{ Session::get('message') }}</p>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-6 rounded my-4" role="alert">
                            <ul id="errors list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ action('App\Http\Controllers\VolunteerController@update',
                    $volunteer->id) }}"
                          role="form">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <div class="w-full border-2 border-gray-300 rounded-xl p-8 my-4">
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2"
                                       for="name">
                                    First Name
                                </label>
                                <input
                                    class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                    id="name" name="name" type="text" placeholder="Name" value="{{
                                    $volunteer->name }}">
                            </div>
                            <div class="mb-4">
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="phone">
                                    Phone
                                </label>
                                <input
                                    class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                    id="phone" name="phone" type="text" value="{{ $volunteer->phone }}">
                            </div>
                            <div>
                                <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="email">
                                    Email
                                </label>
                                <input
                                    class="shadow border-gray-300 rounded w-full md:w-1/2 py-2 px-3 text-grey-darker"
                                    id="email" name="email" type="email" value="{{ $volunteer->email }}">
                            </div>
                        </div>
                        <div class="w-full border-2 border-gray-300 rounded-xl p-8 flex flex-wrap">
                            <div class="w-full md:w-1/2">
                                <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">Vetting information:</h4>
                                <div class="mb-4">
                                    <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2"
                                           for="vetting_completion">
                                        Vetting completion
                                    </label>
                                    <input
                                        class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                        id="vetting_completion" name="vetting_completion" type="date"
                                        value="{{ $volunteer->vetting_completion }}">
                                </div>
                                <div>
                                    <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2"
                                           for="vetting_expiry">
                                        Vetting expiry
                                    </label>
                                    <input
                                        class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                        id="vetting_expiry" name="vetting_expiry" type="date" value="{{
                                        $volunteer->vetting_expiry }}">
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <h4 class="w-auto text-gray-500 text-xl font-bold mb-6">Safeguarding
                                    information:</h4>
                                <div class="mb-4">
                                    <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2"
                                           for="safeguarding_completion">
                                        Safeguarding completion
                                    </label>
                                    <input
                                        class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
                                        id="safeguarding_completion" name="safeguarding_completion" type="date"
                                        value="{{ $volunteer->safeguarding_completion }}">
                                </div>
@include('partials.safeguarding-level-expiries', ['role' => 'Volunteer', 'record' => $volunteer])
                            </div>
                        </div>
                        <div class="mt-6">
                            <input type="submit" value="Save changes" class="button-judo">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
