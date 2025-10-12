<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run(): void {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call([
            MaterialSeeder::class,
            ProductSeeder::class,
            ProcedureSeeder::class,
            FinancialTypeSeeder::class,
            FinancialCategorySeeder::class,
            FinancialItemSeeder::class,
        ]);
    }
}
