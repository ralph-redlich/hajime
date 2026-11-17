<?php

namespace App\Http\Controllers;

use App\Models\Options;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    public function logsPage()
    {
        $logs = Activity::with(["causer", "subject"])->latest()->paginate(25)->withQueryString();

        return view('pages.logs-page', compact('logs'));
    }

    public function adminList()
    {
        return view('pages.admin-list');
    }

    public function optionsPage()
    {

        return view('pages.options');
    }

    public function clubAccessDisabled()
    {
        return view('pages.club-access-disabled');
    }
}
