<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'date_of_birth' => $this->faker->date,
            'married' => $this->faker->boolean,
            'number_of_kids' => $this->faker->numberBetween(0, 5),
            'profile_picture' => $this->faker->imageUrl(100, 100, 'people'),
            'phone_numbers' => json_encode([
                ['Phone' => $this->faker->phoneNumber],
                ['Fax' => $this->faker->phoneNumber]
            ]),
            'company_id' => Company::inRandomOrder()->first()->id, 
        ];
    }
}
