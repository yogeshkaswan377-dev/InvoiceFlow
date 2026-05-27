<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;

        return view('settings.index', compact('company'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',

            'gst_rates' => 'nullable|array',

            'bank_details' => 'nullable|array',

            'bank_details.*.bank_name' => 'nullable|string',

            'bank_details.*.account_number' => 'nullable|string',

            'bank_details.*.holder_name' => 'nullable|string',

            'bank_details.*.ifsc' => [
                'nullable',
                'string',
                'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'
            ],

            'bank_details.*.branch' => 'nullable|string',

            'bank_details.*.upi_id' => 'nullable|string',

            'bank_details.*.is_default' => 'nullable|boolean',
        ]);

        // GST validation
        if (isset($validated['gst_rates'])) {

            foreach ($validated['gst_rates'] as $rate) {

                if (
                    isset($rate['cgst'], $rate['sgst'], $rate['rate'])
                ) {

                    if (
                        ($rate['cgst'] + $rate['sgst'])
                        !=
                        $rate['rate']
                    ) {

                        return back()->withErrors([
                            'gst_rates' => 'Invalid GST distribution'
                        ]);
                    }
                }
            }
        }

        $company = auth()->user()->company;

        $company->update([

            'name' => $validated['company_name']
                ?? $company->name,

            'company_name' => $validated['company_name']
                ?? $company->company_name,

            'phone' => $validated['phone']
                ?? $company->phone,

            'gstin' => $validated['gstin']
                ?? $company->gstin,

            'pan' => $validated['pan']
                ?? $company->pan,

            'cin' => $validated['cin']
                ?? $company->cin,

            'website' => $validated['website']
                ?? $company->website,

            'gst_rates' => $validated['gst_rates']
                ?? $company->gst_rates,

            'bank_details' => $validated['bank_details']
                ?? $company->bank_details,
        ]);

        return redirect()->back();
    }

    public function uploadLogo(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('logo')) {

            $path = $request->file('logo')
                ->store('logos', 'public');

            $company = auth()->user()->company;

            if ($company->logo_path) {
                Storage::disk('public')
                    ->delete($company->logo_path);
            }

            $company->update([
                'logo_path' => $path
            ]);

            return redirect()->back();
        }

        return back()->withErrors([
            'logo' => 'No file uploaded'
        ]);
    }

    public function uploadSignature(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'
        ]);

        if ($request->hasFile('signature')) {

            $path = $request->file('signature')
                ->store('signatures', 'public');

            $company = auth()->user()->company;

            if ($company->signature_path) {
                Storage::disk('public')
                    ->delete($company->signature_path);
            }

            $company->update([
                'signature_path' => $path
            ]);

            return redirect()->back();
        }

        return back()->withErrors([
            'signature' => 'No file uploaded'
        ]);
    }

    public function removeMedia(Request $request)
{
    $company = auth()->user()->company;

    if ($company->logo_path) {

        Storage::disk('public')->delete(
            $company->logo_path
        );

        $company->update([
            'logo_path' => null
        ]);
    }

    return redirect()->back();
}
}
