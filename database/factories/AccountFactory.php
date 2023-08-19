<?php

namespace Database\Factories;

use App\Helpers\DatetimeHelper;
use App\Traits\FactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    use FactoryTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->unique()->safeEmail;

        return [
            'full_name' => fake()->name,
            'email' => $email,
            'password' => bcrypt($email.'123'),
            'last_time_login' => DatetimeHelper::getDatetime(),
            'created_at' => DatetimeHelper::getDatetime(),
            'created_by' => $email,
            'updated_at' => DatetimeHelper::getDatetime(),
            'updated_by' => $email,
        ];
    }

    /**
     * state Columns
     * @param array $column_value
     * @return Factory
     */
    public function stateColumns(array $column_value): Factory
    {
        return $this->stateFactory($this, $column_value);
    }

}
