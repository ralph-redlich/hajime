{{-- Per-level Safeguarding expiry dates (CR26-001 R6a). Expects $record (Personnel, Coach or Volunteer). --}}
@foreach ([1, 2, 3] as $level)
    <div class="mb-4">
        <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="safeguarding_l{{ $level }}_expiry">
            Safeguarding Level {{ $level }} expiry
        </label>
        <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
               id="safeguarding_l{{ $level }}_expiry" name="safeguarding_l{{ $level }}_expiry" type="date"
               value="{{ $record->{'safeguarding_l'.$level.'_expiry'} }}">
    </div>
@endforeach
