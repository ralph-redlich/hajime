@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header
                class="font-bold text-xl bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md flex justify-between align-middle">
                <div>
                    {{ ucfirst($member->first_name) }} {{ ucfirst($member->last_name) }}
                <span class="text-sm text-gray-500 ml-2">No: {{ $member->number }}</span>

                @if ($member->active)
                <span class="text-sm text-green-700 bg-green-300 p-2 rounded ml-2">Active</span>
                @else
                <span class="text-sm text-red-700 bg-red-300 p-2 rounded ml-2">Inactive</span>
                @endif
                    <a href="{{ route('member.edit', $member) }}" class="text-green-600 font-bold ml-3"
                        title="Edit club details"><i class="far fa-edit"></i></a>
                </div>
                <div class="font-bold text-sm"> Club: {{ $member->club->name }} </div>
            </header>

            <div class="w-full p-6">
                <a href="{{ route('clubs.show', $member->club) }}"
                    class="text-blue-500 font-bold hover:text-blue-300 mb-4" title="View club page">
                    << Back to club view</a> <div
                        class="w-full border border-gray-300 flex flex-wrap rounded-xl my-4 p-4">
                        <div class="w-full md:w-1/2">
                            <h4 class="font-bold text-xl text-gray-500 mb-4">Personal details:</h4>
                            <div class="mb-8">
                                <div class="w-full md:w-1/2 mb-4">
                                    <div class="w-full flex flex-wrap mb-4">
                                        <div class="w-36 font-bold">Date of birth:</div>
                                        <div class="w-auto">{{ $member->dob }}
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-wrap mb-4">
                                        <div class="w-36 font-bold">Current age:</div>
                                        <div class="w-auto">{{ $member->age }}
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-wrap mb-4">
                                        <div class="w-36 font-bold">Gender:</div>
                                        <div class="w-auto">{{ $member->gender }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2">
                            <h4 class="font-bold text-xl text-gray-500 mb-4">Contact details:</h4>
                            <div class="flex flex-wrap">
                                <div class="w-full flex flex-wrap">
                                    <div class="w-full flex flex-wrap mb-4">
                                        <div class="w-36 font-bold">Phone:</div>
                                        <div class="w-auto">{{ $member->phone }}
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-wrap mb-4">
                                        <div class="w-36 font-bold">Mobile:</div>
                                        <div class="w-auto">{{ $member->mobile }}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex flex-wrap mb-4">
                                    <div class="w-36 font-bold">Email:</div>
                                    <div class="w-auto">{{ $member->email }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mb-2">
                            <h4 class="font-bold text-xl text-gray-500 mb-4 ">Address:</h4>
                            <div class="w-full md:w-1/2 flex flex-wrap">
                                {{ $member->address1}}, @if ($member->address2)
                                , {{ $member->address2}}
                                @endif
                                {{ $member->city}}, {{ $member->county}}, {{ $member->province}}
                            </div>
                        </div>
            </div>
            {{-- MEMBERSHIP SECTION --}}
            <div class="w-full border-2 border-gray-300 rounded-xl my-4 p-4">
                    <h4 class="font-bold text-xl text-gray-500 mb-4">Membership details:</h4>
                    <form method="POST" action="{{ action('App\Http\Controllers\MembershipController@store') }}"
                          role="form">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <div class="flex flex-wrap justify-between">
                            <div class="flex flex-wrap">
                                <div>
                                    <label for="membership_type"
                                           class="block text-sm text-gray-400 mb-2 font-bold">Membership type</label>
                                    <input type="text" name="membership_type" id="membership_type"
                                           class="shadow appearance-none border rounded w-64 py-2 px-3 text-grey-darker mr-2"
                                           placeholder="Membership type">
                                </div>
                                <div>
                                    <label for="join_date" class="block text-sm text-gray-400 mb-2 font-bold">Joining
                                        date</label>
                                    <input type="date" name="join_date" id="join_date"
                                           class="shadow appearance-none border rounded w-48 py-2 px-3 text-grey-darker mr-2">
                                </div>
                                <div>
                                    <label for="expiry_date" class="block text-sm text-gray-400 mb-2 font-bold">Expiry
                                        date</label>
                                    <input type="date" name="expiry_date" id="expiry_date"
                                           class="shadow appearance-none border rounded w-48 py-2 px-3 text-grey-darker mr-2">
                                </div>
                            </div>
                            <div>
                                <input type="submit" value="Submit" class="button-judo">
                            </div>
                        </div>
                    </form>
                    <div class="w-full">
                        <table class="min-w-full table leading-normal mt-8">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Membership type
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Join date
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Expiry date
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-red-500 uppercase tracking-wider">
                                    Remove
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($memberships as $membership)
                                <tr>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $membership->membership_type }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $membership->join_date }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $membership->expiry_date }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <form action="{{ route('membership.destroy' , $membership)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <input type="hidden" name="member_id" value="{{$member->id }}" />
                                            <button type="submit" class="text-red-600 hover:text-red-300 whitespace-no-wrap" onclick="return confirm('Do you want to delete the record completely?')"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            {{-- GRADING SECTION --}}
            <div class="w-full border-2 border-gray-300 rounded-xl my-4 p-4">
                <h4 class="font-bold text-xl text-gray-500 mb-4">Grading details:</h4>
                <form method="POST" action="{{ action('App\Http\Controllers\GradeController@store') }}" role="form">
                    @csrf
                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                    <div class="flex flex-wrap justify-between">
                        <div class="flex flex-wrap">
                            <div>
                                <label for="grade_level" class="block text-sm text-gray-400 mb-2 font-bold">Grade
                                    level</label>
                                <select name="grade_level" id="grade_level" class="shadow appearance-none border rounded w-48 py-2 px-3 text-grey-darker mr-2">>
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
                                        <option value="6th Dan">6th Dan</option>
                                        <option value="7th Dan">7th Dan</option>
                                        <option value="7th Dan">7th Dan</option>
                                        <option value="8th Dan">8th Dan</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label for="type" class="block text-sm text-gray-400 mb-2 font-bold">Date
                                    attained</label>
                                <input type="date" name="grade_date" id="grade_date"
                                    class="shadow appearance-none border rounded w-48 py-2 px-3 text-grey-darker mr-2">
                            </div>
                            <div>
                                <label for="type" class="block text-sm text-gray-400 mb-2 font-bold">Points to next
                                    grade</label>
                                <input type="text" name="grade_points" id="grade_points"
                                    class="shadow appearance-none border rounded w-64 py-2 px-3 text-grey-darker mr-2"
                                    placeholder="Points to next grade">
                            </div>

                        </div>
                        <div>
                            <input type="submit" value="Submit" class="button-judo">

                        </div>
                    </div>
                </form>

                <div class="w-full">
                    <table class="min-w-full table leading-normal mt-8">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Grade level
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Grade date
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Points to next
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-red-500 uppercase tracking-wider">
                                    Remove
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades as $grade)
                            <tr class="odd:bg-white even:bg-gray-200">
                                <td class="px-5 py-2 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $grade->grade_level}}
                                        @if ($grade->auto_transferred)
                                            <span class="text-xs text-gray-500">(automatic transfer at 14)</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $grade->grade_date}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $grade->grade_points}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 text-sm">
                                    <form action="{{ route('grade.destroy' , $grade)}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <input type="hidden" name="member_id" value="{{$member->id }}" />
                                        <button type="submit" class="text-red-600 hover:text-red-300 whitespace-no-wrap" onclick="return confirm('Do you want to delete the record completely?')"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- NOTES SECTION --}}
            <div class="w-full border-2 border-gray-300 rounded-xl my-4 p-4">
                    <h4 class="font-bold text-xl text-gray-500 mb-4" id="notes">Member notes:</h4>
                    <a href="{{ route('membernote.create.member', [$member->id]) }}">
                        <button class="button-judo">+ Add new note</button>
                    </a>
                    <div class="w-full mt-8">
                        <table class="min-w-full table leading-normal mt-8">
                            <thead>
                            <tr>
                                <th
                                    class="w-3/4 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="w-1/4 px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Operations
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($notes as $note)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap font-bold">
                                                    <a href="{{ route('membernote.show', $note->slug) }}" class="hover:text-cool-gray-400" title="View full note">{{ $note->title }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm flex flex-wrap">
                                        <a href="{{ route('membernote.show', $note->slug) }}" class="text-blue-600 font-bold hover:text-blue-300" title="View full note"><i class="far fa-eye"></i></a>
                                        <a href="{{ route('membernote.edit', $note) }}" class="text-green-600 font-bold ml-3" title="Edit note"><i class="far fa-edit"></i></a>
                                        <form action="{{ route('membernote.destroy' , $note)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" class="text-red-600 hover:text-red-300 whitespace-no-wrap ml-3" onclick="return confirm('Do you want to delete the record completely?')"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            <!-- Forms Section -->
            <div class="w-full border border-gray-300 rounded-xl my-4 p-4">
                <h4 class="font-bold text-xl mb-4" id="forms">Member forms:</h4>
                <div>
                    <button class="button-judo" onclick="showForm()">+ Add new form</button>
                </div>
                <div class="w-full my-4 hidden bg-gray-100 p-2 rounded" id="addForm">
                    <form action="{{ route('memberdoc.store') }}" method="POST" role="form" class="w-full flex
                    flex-wrap
                    justify-between" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <input type="hidden" name="type" value="Form">
                        <div class="flex flex-wrap w-1/2 mr-4">
                            <label class="inline-block text-gray-600 text-sm font-bold mr-4 py-2" for="title">
                                Title
                            </label>
                            <input
                                class="shadow appearance-none border w-5/6 rounded px-3 text-grey-darker"
                                id="title" name="title" type="text" required>
                        </div>
                        <div class="flex flex-wrap align-middle">
                            <label class="inline-block text-gray-600 text-sm font-bold mr-4 py-2" for="link">
                                Attachment
                            </label>
                            <input class="py-2" id="link" name="link" type="file" required>
                        </div>
                        <div class="mr-8 py-2">
                            <input type="submit" value="Submit" class="button-judo">
                        </div>
                        <div class="mr-8 py-2">
                            <button class="button-danger" onclick="hideForm()">Cancel</button>
                        </div>
                    </form>
                </div>

                <div class="w-full mt-8">
                    <table class="min-w-full table leading-normal mt-8">
                        <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Title
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Created by
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Link
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Created on
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Operations
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($forms as $form)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap font-bold">
                                                {{ $form->title }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    Author
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <a href="{{ asset('/storage/attachments/'.$form->link) }}" target="_blank">
                                        <i class="fas fa-file-pdf text-2xl text-red-700"></i>
                                    </a>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    {{ $form->created_at->format('d-m-Y') }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex flex-wrap">
                                    <form action="{{ route('memberdoc.destroy', $form->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="text-red-600 hover:text-red-300 whitespace-no-wrap ml-3" onclick="return confirm('Do you want to delete the record completely?')"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="w-full border border-gray-300 rounded-xl my-4 p-4">
                    <h4 class="font-bold text-xl mb-4" id="documents">Member Documents:</h4>
                    <div>
                        <button class="button-judo" onclick="showDocForm()">+ Add new document</button>

                    </div>
                    <div class="w-full my-4 hidden bg-gray-100 p-2 rounded shadow" id="addDocument">
                        <form action="{{ route('memberdoc.store') }}" method="POST" role="form" class="w-full flex
                        flex-wrap
                        justify-between" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                            <input type="hidden" name="type" value="Document">
                            <div class="flex flex-wrap w-1/2 mr-4">
                                <label class="inline-block text-gray-600 text-sm font-bold mr-4 py-2" for="title">
                                    Title
                                </label>
                                <input
                                    class="shadow appearance-none border w-5/6 rounded px-3 text-grey-darker"
                                    id="title" name="title" type="text" required>
                            </div>
                            <div class="flex flex-wrap align-middle">
                                <label class="inline-block text-gray-600 text-sm font-bold mr-4 py-2" for="link">
                                    Attachment
                                </label>
                                <input class="py-2" id="link" name="link" type="file" required>
                            </div>
                            <div class="mr-8 py-2">
                                <input type="submit" value="Submit" class="button-judo">
                            </div>
                            <div class="mr-8 py-2">
                                <button class="button-danger" onclick="hideDocForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="w-full mt-8">
                        <table class="min-w-full table leading-normal mt-8">
                            <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Created by
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Link
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Created on
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Operations
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap font-bold">
                                                    {{ $document->title }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        Author
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="{{ asset('/storage/attachments/'.$document->link) }}" target="_blank">
                                            <i class="fas fa-file-pdf text-2xl text-red-700"></i>
                                        </a>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ $document->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex flex-wrap">
                                        <form action="{{ route('memberdoc.destroy', $document->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" class="text-red-600 hover:text-red-300 whitespace-no-wrap ml-3" onclick="return confirm('Do you want to delete the record completely?')"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
    </section>
    </div>
</main>
@endsection


@section('bottomScripts')
    <script>
        function showForm() {
            let docForm = document.getElementById('addForm');
            docForm.classList.remove("hidden");
        }
        function hideForm() {
            let docForm = document.getElementById('addForm');
            docForm.classList.add("hidden");
        }
        function showDocForm() {
            let docForm = document.getElementById('addDocument');
            docForm.classList.remove("hidden");
        }
        function hideDocForm() {
            let docForm = document.getElementById('addDocument');
            docForm.classList.add("hidden");
        }
    </script>
@endsection
