<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $staff;
    protected ?Company $company = null;
    protected function setUp(): void
    {
        parent::setUp();

        // ✅ USE existing company from seeder (ID 1)
        $this->company = Company::first();  // NOT Company::create()

        // If no company exists (fallback)
        if (!$this->company) {
            $this->company = Company::create([
                'name' => 'Demo Business',
                'gstin' => '27ABCDE1234F1Z5',
                'state_code' => '27',
                'state_name' => 'Maharashtra',
                'is_active' => true,
            ]);
        }

        // Create roles
        Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

        // Create owner user
        $this->owner = User::create([
            'name' => 'Rahul Mehta',
            'email' => 'rahul.mehta@gmail.com',
            'company_id' => $this->company->id,
            'password' => bcrypt('password'),
        ]);
        $this->owner->assignRole('owner');

        // Create staff user
        $this->staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'company_id' => $this->company->id,
            'password' => bcrypt('password'),
        ]);
        $this->staff->assignRole('staff');

        // Set session
        session(['current_company_id' => $this->company->id]);
    }

    public function test_owner_can_view_clients_list(): void
    {
        Client::factory()->count(3)->create([
            'company_id' => $this->company->id,
        ]);

        $response = $this->actingAs($this->owner)
            ->get(route('clients.index'));

        $response->assertOk();
    }

    public function test_owner_can_create_business_client_with_gstin(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'company_name' => 'ABC Pvt Ltd',
                'name' => 'Raj Patel',
                'gstin' => '24ABCDE1234F1Z5',
                'state' => 'Gujarat',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('clients', [
            'company_name' => 'ABC Pvt Ltd',
            'gstin' => '24ABCDE1234F1Z5',
        ]);
    }

    public function test_owner_can_create_individual_client_without_gstin(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'individual',
                'name' => 'Amit Shah',
                'state' => 'Gujarat',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('clients', [
            'name' => 'Amit Shah',
            'gstin' => null,
        ]);
    }

    public function test_owner_can_edit_client(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $response = $this->actingAs($this->owner)
            ->put(route('clients.update', $client), [
                'name' => 'Updated Name',
                'client_type' => $client->client_type,

                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Updated Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_owner_can_delete_client(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $response = $this->actingAs($this->owner)
            ->delete(route('clients.destroy', $client));

        $response->assertRedirect();

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    public function test_business_client_requires_gstin(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'company_name' => 'ABC Pvt Ltd',
                'name' => 'Raj',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('gstin');
    }

    public function test_business_client_requires_company_name(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'gstin' => '24ABCDE1234F1Z5',
                'name' => 'Raj',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('company_name');
    }

    public function test_gstin_must_be_unique_per_company(): void
    {
        Client::factory()->create([
            'company_id' => $this->company->id,
            'gstin' => '24ABCDE1234F1Z5',
        ]);

        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'company_name' => 'Duplicate GST',
                'name' => 'Test',
                'gstin' => '24ABCDE1234F1Z5',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('gstin');
    }

    public function test_gstin_validation_rejects_invalid_format(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'company_name' => 'ABC Pvt Ltd',
                'name' => 'Raj',
                'gstin' => 'INVALIDGSTIN',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'country' => 'India',
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('gstin');
    }

    public function test_place_of_supply_auto_calculates_intra_state(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
            'state' => 'Gujarat',
        ]);

        $this->assertTrue(
            $client->place_of_supply === 'intra_state'
        );
    }

    public function test_place_of_supply_auto_calculates_inter_state(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
            'state' => 'Maharashtra',
        ]);

        $this->assertTrue(
            $client->place_of_supply === 'inter_state'
        );
    }

    public function test_export_client_has_no_gstin_requirement(): void
    {
        $response = $this->actingAs($this->owner)
            ->post(route('clients.store'), [
                'client_type' => 'business',
                'name' => 'Foreign Client',
                'country' => 'USA',
                'state_code' => '24',
                'state_name' => 'Gujarat',
                'address_line_1' => 'Test Address',
                'city' => 'Ahmedabad',
                'pincode' => '380001',
                'is_active' => true,

            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('clients', [
            'name' => 'Foreign Client',
        ]);
    }

    public function test_search_clients_by_name_works(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
            'name' => 'Rohit Sharma',
            'gstin' => '24ABCDE1234F1Z5',
            'state_name' => 'Gujarat',
        ]);

        $response = $this->actingAs($this->owner)
            ->get('/clients/search?q=Rohit');

        $response->assertOk();
        $response->assertSee('Rohit Sharma');
    }

    public function test_search_clients_by_gstin_works(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
            'gstin' => '24ABCDE1234F1Z5',
            'name' => 'Test Client',
        ]);

        $response = $this->actingAs($this->owner)
            ->get('/clients/search?q=24ABCDE');

        $response->assertOk();
        $response->assertSee('24ABCDE1234F1Z5');
    }

    public function test_filter_clients_by_state_works(): void
    {
        Client::factory()->create([
            'company_id' => $this->company->id,
            'state' => 'Gujarat',
        ]);

        Client::factory()->create([
            'company_id' => $this->company->id,
            'state' => 'Maharashtra',
        ]);

        $response = $this->actingAs($this->owner)
            ->get(route('clients.filter.state', [
                'state' => 'Gujarat'
            ]));

        $response->assertOk();

        $response->assertSee('Gujarat');
        $response->assertDontSee('Maharashtra');
    }

    public function test_filter_clients_by_status_works(): void
    {
        Client::factory()->create([
            'company_id' => $this->company->id,
            'status' => 'active',
        ]);

        Client::factory()->create([
            'company_id' => $this->company->id,
            'status' => 'inactive',
        ]);

        $response = $this->actingAs($this->owner)
            ->get(route('clients.filter.status', [
                'status' => 'active'
            ]));

        $response->assertOk();
    }

    public function test_staff_can_view_clients(): void
    {
        $response = $this->actingAs($this->staff)
            ->get(route('clients.index'));

        $response->assertOk();
    }

    public function test_staff_cannot_delete_clients(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $response = $this->actingAs($this->staff)
            ->delete(route('clients.destroy', $client));

        $response->assertForbidden();
    }
}
