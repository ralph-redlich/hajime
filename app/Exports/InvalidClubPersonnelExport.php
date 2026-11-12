<?php

namespace App\Exports;

use App\Support\InvalidClubPersonnel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvalidClubPersonnelExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return InvalidClubPersonnel::rows();
    }

    public function map($row): array
    {
        return [
            $row['club'],
            $row['name'],
            $row['role'],
            $row['reason'],
            $row['vetting_expiry'],
            $row['safeguarding_l1_expiry'],
            $row['safeguarding_l2_expiry'],
            $row['safeguarding_l3_expiry'],
            $row['first_aid_expiry'],
        ];
    }

    public function headings(): array
    {
        return ['Club', 'Name', 'Role', 'Reason', 'Vetting Expiry', 'Safeguarding L1 Expiry', 'Safeguarding L2 Expiry', 'Safeguarding L3 Expiry', 'First Aid Expiry'];
    }

    public function title(): string
    {
        return 'Invalid Club Personnel';
    }
}
