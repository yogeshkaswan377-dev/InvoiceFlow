<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->currentCompany;
        
        return view('dashboard', [
            'company' => $company,
            'user' => $user
        ]);
    }
}