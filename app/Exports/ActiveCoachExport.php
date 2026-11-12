<?php

namespace App\Exports;

use App\Models\Coach;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActiveCoachExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Coach::where('vetting_expiry', '>=', now())
        ->where(fn ($q) => $q->where('safeguarding_l1_expiry', '>=', now())
                ->orWhere(fn ($q) => $q->whereNull('safeguarding_l1_expiry')->where('safeguarding_expiry', '>=', now())))
        ->orderBy('club_id', 'asc')->with('club:id,name')->get();;
    }

    public function map($coach): array
    {
        return [
            $coach->club->name,
            $coach->name,
            $coach->vetting_expiry,
            $coach->safeguarding_expiry,
            $coach->first_aid_expiry,
            $coach->coaching_qualification,
        ];
    }

    public function headings(): array
    {
        return [
            'Club',
            'Name',
            'Vetting Expiry',
            'Safeguarding Expiry',
            'First Aid Expiry',
            'Qualifications',
        ];
    }

    public function title(): string
    {
        return 'Active Coaches';
    }
}
