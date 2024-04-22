<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::factory(1000)->create();
    }
}
