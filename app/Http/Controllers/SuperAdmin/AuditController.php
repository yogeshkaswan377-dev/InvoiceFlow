<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class AuditController extends Controller
{
    public function index()
    {
        $companies = \App\Models\Company::all();
        return view('super-admin.audit.index', compact('companies'));
    }
}
