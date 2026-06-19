<?php

namespace App\Http\Controllers;

use App\Models\CompanyInvite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    public function inviteForm()
    {
        $companyId = session('current_company_id');
        $staff = User::where('company_id', $companyId)
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['admin', 'staff']);
            })->get();
        $invites = CompanyInvite::where('company_id', $companyId)
            ->whereNull('accepted_at')->get();

        return view('staff.invite', compact('staff', 'invites'));
    }

    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff',
        ]);

        $companyId = session('current_company_id');
        $token = Str::random(64);

        CompanyInvite::create([
            'company_id' => $companyId,
            'invited_by' => auth()->id(),
            'email' => $request->email,
            'role' => $request->role,
            'token' => $token,
        ]);

        $link = route('invite.accept', $token);

        // In production, send email with $link
        // Mail::to($request->email)->send(new StaffInviteMail($link));

        return back()->with('success', "Invite sent! Link: <a href='{$link}'>{$link}</a>");
    }

    public function acceptInvite($token)
    {
        $invite = CompanyInvite::where('token', $token)->whereNull('accepted_at')->firstOrFail();
        return view('auth.invite-register', compact('invite'));
    }

    public function registerFromInvite(Request $request, $token)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $invite = CompanyInvite::where('token', $token)->whereNull('accepted_at')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $invite->email,
            'password' => Hash::make($request->password),
            'company_id' => $invite->company_id,
            'current_company_id' => $invite->company_id,
        ]);

        $user->assignRole($invite->role, $invite->company_id);
        $invite->update(['accepted_at' => now()]);

        auth()->login($user);
        session(['current_company_id' => $invite->company_id]);

        return redirect()->route('dashboard')->with('success', 'Welcome to the team!');
    }
}
