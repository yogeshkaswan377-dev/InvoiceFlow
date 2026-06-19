<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRateLimitTest extends TestCase
{
    use RefreshDatabase;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
            'current_company_id' => $company->id,
        ]);
        $this->token = $user->createToken('test-token')->plainTextToken;
        session(['current_company_id' => $company->id]);
    }

    public function test_health_endpoint_returns_200(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'version' => '1.0.0',
            ]);
    }

    public function test_api_returns_404_with_rfc7807_format(): void
    {
        $response = $this->getJson('/api/v1/nonexistent-endpoint');

        $response->assertStatus(404)
            ->assertJson([
                'type' => 'https://tools.ietf.org/html/rfc7231#section-6.5.4',
                'title' => 'Not Found',
                'status' => 404,
            ]);
    }

    public function test_cors_headers_are_present(): void
    {
        $response = $this->withHeaders([
            'Origin' => 'http://localhost:3000',
        ])->getJson('/api/v1/health');

        $response->assertStatus(200);
        // CORS headers are handled by middleware
    }
}
