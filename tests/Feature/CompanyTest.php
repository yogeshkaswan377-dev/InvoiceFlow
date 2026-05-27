<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->post(route('company.store'), [
            'name' => 'My Business',
            'email' => 'business@example.com',
            'phone' => '9876543210',
            'gstin' => '29ABCDE1234F1Z5',
            'state_code' => '29',
            'pincode' => '560001'
        ]);
        
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('companies', ['name' => 'My Business']);
    }
    
    public function test_gstin_must_be_unique(): void
    {
        Company::factory()->create(['gstin' => '27ABCDE1234F1Z5']);
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->post(route('company.store'), [
            'name' => 'Another Business',
            'gstin' => '27ABCDE1234F1Z5'
        ]);
        
        $response->assertSessionHasErrors('gstin');
    }
    
    public function test_user_can_switch_company(): void
    {
        $company1 = Company::factory()->create(['name' => 'Company A']);
        $company2 = Company::factory()->create(['name' => 'Company B']);
        
        $user = User::factory()->create(['company_id' => $company1->id]);
        $user->assignRole('owner', $company1->id);
        $user->assignRole('owner', $company2->id);
        
        $this->actingAs($user);
        
        $response = $this->post(route('company.set', $company2->id));
        
        $response->assertRedirect(route('dashboard'));
        $this->assertEquals($company2->id, $user->fresh()->current_company_id);
    }
}