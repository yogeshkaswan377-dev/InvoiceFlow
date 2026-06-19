<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiClientTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create(['state_code' => '27']);
        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'current_company_id' => $this->company->id,
        ]);

        $this->user->assignRole('admin', $this->company->id);

        $this->token = $this->user->createToken('test-token')->plainTextToken;
        session(['current_company_id' => $this->company->id]);
    }

    public function test_can_list_clients(): void
    {
        Client::factory()->count(3)->create(['company_id' => $this->company->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v1/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'name', 'client_type', 'gstin'],
                ],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }

    public function test_can_create_client(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v1/clients', [
            'client_type' => 'individual',
            'name' => 'API Test Client',
            'state_code' => '27',
            'state_name' => 'Maharashtra',
            'address_line_1' => '123 API Street',
            'city' => 'Mumbai',
            'pincode' => '400001',
            'country' => 'India',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Client created successfully.',
            ]);

        $this->assertDatabaseHas('clients', ['name' => 'API Test Client']);
    }

    public function test_can_view_single_client(): void
    {
        $client = Client::factory()->create(['company_id' => $this->company->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v1/clients/' . $client->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['id' => $client->id, 'name' => $client->name],
            ]);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create([
            'company_id' => $this->company->id,
            'client_type' => 'individual',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/v1/clients/' . $client->id, [
            'name' => 'Updated API Client',
            'client_type' => 'individual',
            'state_code' => '27',
            'state_name' => 'Maharashtra',
            'address_line_1' => '123 API Street',
            'city' => 'Mumbai',
            'pincode' => '400001',
            'country' => 'India',
        ]);

        // DEBUG: Print actual status and content
        echo "\nStatus: " . $response->status() . "\n";
        echo "Body: " . $response->getContent() . "\n";

        $response->assertStatus(200);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create(['company_id' => $this->company->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/v1/clients/' . $client->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Client deleted successfully.',
            ]);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_can_search_clients(): void
    {
        Client::factory()->create([
            'company_id' => $this->company->id,
            'name' => 'Searchable Client',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v1/clients/search?q=Searchable');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Searchable Client']);
    }
}
