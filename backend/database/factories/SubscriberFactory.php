<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $states = ['active', 'unsubscribed', 'junk', 'bounced', 'unconfirmed'];
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => preg_replace('/@example\..*/', '@ashrafulislam.info', $this->faker->unique()->safeEmail()),
            'state' => $states[rand(0, 4)]
        ];
    }
}
