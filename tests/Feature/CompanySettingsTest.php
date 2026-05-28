<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanySettingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $staff;
    protected ?Company $company = null;

    protected function setUp(): void
    {
        parent::setUp();

        // ✅ Use existing company ID 4
        $this->company = Company::find(1);

        if (!$this->company) {
            $this->company = Company::create([
                'id' => 4,
                'name' => 'Demo Business',
                'gstin' => '29ABCDE1234F1Z5',
                'state_code' => '29',
                'state_name' => 'Karnataka',
                'is_active' => true,
            ]);
        }

        // ✅ Get existing owner user (ID = 1)
        $owner = User::where('company_id', $this->company->id)->first();

        if (!$owner) {
            $owner = User::factory()->create([
                'company_id' => $this->company->id,
            ]);
        }

        $this->owner = $owner;

        // ✅ Assign role using role_user table (NOT 'role' column)
        $this->owner->assignRole('owner');

        // ✅ Create staff user (no 'role' column)
        $this->staff = User::factory()->create([
            'company_id' => $this->company->id,
        ]);
        $this->staff->assignRole('staff', $this->company->id);

        // ✅ Set current company in session
        session(['current_company_id' => $this->company->id]);
    }

    public function test_owner_can_view_settings_page(): void
    {
        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->get(route('settings.index'));

        $response->assertOk();
    }

    public function test_owner_can_update_basic_info(): void
    {
        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.update'), [
                'company_name' => 'Updated Company',
                'email' => 'company@example.com',
                'phone' => '9876543210',
                'address' => 'Ahmedabad',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'company_name' => 'Updated Company',
        ]);
    }

    public function test_owner_can_update_gst_rates(): void
    {
        $gstRates = [
            [
                'rate' => 18,
                'cgst' => 9,
                'sgst' => 9,
                'igst' => 18,
            ]
        ];

        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.update'), [
                'gst_rates' => $gstRates,
            ]);

        $response->assertRedirect();

        $this->company->refresh();

        $this->assertEquals(
            $gstRates,
            $this->company->gst_rates
        );
    }

    public function test_owner_can_upload_logo(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.upload.logo'), [
                'logo' => $file,
            ]);

        $response->assertRedirect();

        Storage::disk('public')->assertExists(
            'logos/' . $file->hashName()
        );
    }

    public function test_owner_can_remove_logo(): void
    {
        Storage::fake('public');

        $path = 'logos/test-logo.png';

        Storage::disk('public')->put($path, 'dummy');

        $this->company->update([
            'logo_path' => $path,
        ]);

        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->delete(route('settings.logo.remove'));

        $response->assertRedirect();

        $this->company->refresh();

        $this->assertNull($this->company->logo_path);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_owner_can_upload_signature(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('signature.png');

        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.upload.signature'), [
                'signature' => $file,
            ]);

        $response->assertRedirect();

        Storage::disk('public')->assertExists(
            'signatures/' . $file->hashName()
        );
    }

    public function test_owner_can_manage_bank_details(): void
    {
        $bankDetails = [
            [
                'bank_name' => 'State Bank of India',
                'account_number' => '1234567890',
                'holder_name' => 'Rahul Sharma',
                'ifsc' => 'SBIN0001234',
                'branch' => 'Ahmedabad',
                'upi_id' => 'rahul@upi',
                'is_default' => true,
            ]
        ];

        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.update'), [
                'bank_details' => $bankDetails,
            ]);

        $response->assertRedirect();

        $this->company->refresh();

        $this->assertEquals(
            $bankDetails,
            $this->company->bank_details
        );
    }

    public function test_staff_cannot_update_settings(): void
    {
        $response = $this->actingAs($this->staff)
            ->post(route('settings.update'), [
                'company_name' => 'Unauthorized Update',
            ]);

        $response->assertForbidden();
    }

    public function test_gst_rates_validation_fails_for_invalid_distribution(): void
    {
        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.update'), [
                'gst_rates' => [
                    [
                        'rate' => 18,
                        'cgst' => 8,
                        'sgst' => 8,
                        'igst' => 18,
                    ]
                ]
            ]);

        $response->assertSessionHasErrors('gst_rates');
    }

    public function test_bank_details_validation_fails_for_invalid_ifsc(): void
    {
        $response = $this->actingAs($this->owner)
            ->withSession([
                'current_company_id' => $this->company->id
            ])
            ->post(route('settings.update'), [
                'bank_details' => [
                    [
                        'bank_name' => 'HDFC',
                        'account_number' => '123456789',
                        'holder_name' => 'Test User',
                        'ifsc' => 'INVALID123',
                    ]
                ]
            ]);

        $response->assertSessionHasErrors(
            'bank_details.0.ifsc'
        );
    }
}
