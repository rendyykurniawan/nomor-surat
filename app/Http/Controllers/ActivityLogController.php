<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->modul, fn($q) => $q->where('modul', $request->modul))
            ->when($request->search, fn($q) => $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$request->search}%")))
            ->latest()
            ->paginate(20);

        $modulList = ActivityLog::select('modul')->distinct()->pluck('modul');

        return view('log.index', compact('logs', 'modulList'));
    }
}
