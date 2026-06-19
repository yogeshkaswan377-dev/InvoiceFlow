<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('super-admin.settings.index');
    }

    public function update(Request $request)
    {
        // Save platform settings
        return back()->with('success', 'Settings updated!');
    }
}
