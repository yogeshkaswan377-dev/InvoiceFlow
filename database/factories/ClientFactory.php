<?php
// database/factories/ClientFactory.php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'client_type' => $this->faker->randomElement(['business', 'individual']),
            'name' => $this->faker->name(),
            'company_name' => $this->faker->company(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'gstin' => $this->faker->regexify('[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[Z]{1}[0-9A-Z]{1}'),
            'state_code' => '29',
            'state_name' => 'Karnataka',
            'address_line_1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'pincode' => $this->faker->regexify('[1-9][0-9]{5}'),
            'country' => 'India',
            'place_of_supply' => 'Intra-State Supply',
            'credit_limit' => 0,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    public function business(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_type' => 'business',
            'company_name' => $this->faker->company(),
        ]);
    }
    
    public function individual(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_type' => 'individual',
            'gstin' => null,
        ]);
    }
    
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
    
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}