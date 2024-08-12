<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::insert([
            [
                'name' => "Mobile Apps",
            ],
            [
                'name' => "QA",
            ],
            [
                'name' => "Full Stack",
            ],
            [
                'name' => "Backend",
            ],
            [
                'name' => "Frontend",
            ],
            [
                'name' => "UI/UX Designer",
            ],
        ]);
    }
}