<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;

class SubscriptionController extends Controller
{
    public function index()
    {
        $companies = Company::with('owner')->paginate(20);
        return view('super-admin.subscriptions.index', compact('companies'));
    }
}
