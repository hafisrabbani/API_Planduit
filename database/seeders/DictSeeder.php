<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dictionary::factory()->count(100)->create();
    }
}
