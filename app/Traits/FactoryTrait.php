<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;

trait FactoryTrait
{

    /**
     * set state to factory
     * @param Factory $factory
     * @param array $column_value
     * @return Factory
     */
    public function stateFactory(Factory $factory, array $column_value): Factory
    {
        return $factory->state(function () use ($column_value) {
            return $column_value;
        });
    }

}
