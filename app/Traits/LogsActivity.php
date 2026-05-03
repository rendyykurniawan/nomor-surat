<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function log(string $aktivitas, string $modul, string $keterangan = ''): void
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aktivitas'  => $aktivitas,
            'modul'      => $modul,
            'keterangan' => $keterangan,
            'ip_address' => request()->ip(),
        ]);
    }
}
