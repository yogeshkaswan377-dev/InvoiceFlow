<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = File::exists($logFile) ? File::lines($logFile)->reverse()->take(100)->toArray() : [];
        return view('super-admin.logs', compact('logs'));
    }
}
