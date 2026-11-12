<div class="w-full mt-8 memberships-table">
    {{-- Make the actively sorted column obvious: tinted header, bold label, larger chevron. --}}
    <style>
        .memberships-table th[aria-sort] {
            background-color: rgb(72 150 43 / 0.15);
            box-shadow: inset 0 -3px 0 #48962b;
        }
        .memberships-table th[aria-sort] .fi-ta-header-cell-label {
            color: #2e6119;
            font-weight: 700;
        }
        .memberships-table th[aria-sort] .fi-ta-header-cell-sort-icon {
            color: #48962b;
            width: 1.5rem;
            height: 1.5rem;
        }
    </style>

    {{ $this->table }}
</div>
