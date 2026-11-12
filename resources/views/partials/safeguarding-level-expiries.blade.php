{{-- Safeguarding expiry for the level this role requires (CR26-001 R6a/R6b).
     Expects $role (nullable; Childrens Officer = L2, Designated Person = L3, else L1) and optionally $record. --}}
@php
    $level = \App\Support\InvalidClubPersonnel::requiredLevel($role ?? null);
    $field = 'safeguarding_l'.$level.'_expiry';
    $value = old($field, isset($record) ? ($record->{$field} ?: $record->safeguarding_expiry) : null);
@endphp
<div class="mb-4">
    <label class="inline-block w-48 text-grey-darker text-sm font-bold mb-2" for="{{ $field }}">
        Safeguarding L{{ $level }} expiry
    </label>
    <input class="shadow border-gray-300 rounded w-3/4 md:w-48 py-2 px-3 text-grey-darker"
           id="{{ $field }}" name="{{ $field }}" type="date" value="{{ $value }}" placeholder="2020-01-01">
</div>
