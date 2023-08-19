<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $accountHasStore = Account::factory(10)->create()->first();

        echo "The seeding database has just been done.".PHP_EOL.PHP_EOL;
    }

}

