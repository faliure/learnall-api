<?php

namespace Database\Seeders;

use App\Models\Learnable;
use Illuminate\Database\Seeder;

class LearnableSeeder extends Seeder
{
    public function run()
    {
        Learnable::factory()->count(50)->create();
    }
}
