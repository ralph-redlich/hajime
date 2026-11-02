<?php

namespace App\Http\Controllers\Reports;

use App\Exports\InvalidClubPersonnelExport;
use App\Http\Controllers\Controller;
use App\Support\InvalidClubPersonnel;
use Maatwebsite\Excel\Facades\Excel;

class InvalidClubPersonnelReportController extends Controller
{
    public function index()
    {
        $personnel = InvalidClubPersonnel::rows();

        return view('report.invalid-personnel', compact('personnel'));
    }

    public function export()
    {
        return Excel::download(new InvalidClubPersonnelExport(), 'invalid-club-personnel-'.date('Y-m-d').'.xlsx');
    }
}
