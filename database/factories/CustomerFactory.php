<?php

namespace Database\Factories;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' =>  Hash::make(12345678)
                // 'fcm_token' => Str::random(100) // or use any logic to generate FCM tokens
            ];
        
    }
}
