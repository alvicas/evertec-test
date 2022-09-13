<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_mobile' => $this->faker->e164PhoneNumber(),
            'status' => Order::STATUS_CREATED,
            'product_id' => User::factory()->create(),
            'identifier_code' => $this->faker->unique()->regexify('[A-Z]{5}[0-4]{3}'),
            'payment_url' => null,
            'payment_session' => null,
            'payment_date' => null
        ];
    }
}
