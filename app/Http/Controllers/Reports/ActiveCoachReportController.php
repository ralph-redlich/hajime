<?php

namespace App\Http\Controllers\Reports;

use App\Exports\ActiveCoachExport;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActiveCoachReportController extends Controller
{
    public function index()
    {
        $coaches = Coach::where('vetting_expiry', '>=', now())
            ->where(fn ($q) => $q->where('safeguarding_l1_expiry', '>=', now())
                ->orWhere(fn ($q) => $q->whereNull('safeguarding_l1_expiry')->where('safeguarding_expiry', '>=', now())))
            ->orderBy('club_id', 'asc')->with('club:id,name')->get();
        return view('report.active-coach', compact('coaches'));
    }

    public function export()
    {
        $filename = 'active-coaches-'.date('Y-m-d').'.xlsx';
        return Excel::download(new ActiveCoachExport(), $filename);
    }
}
