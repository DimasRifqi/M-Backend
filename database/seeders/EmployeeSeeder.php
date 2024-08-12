<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::insert([
            [
                'image' => "https://www.google.com/url?sa=i&url=https%3A%2F%2Fid.pinterest.com%2Fpin%2F806003664554583008%2F&psig=AOvVaw17KZd3RyQpdck7xaULXyXq&ust=1723549567870000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCNCqlNKw74cDFQAAAAAdAAAAABAE",
                'name' => "Siti Nurdayah",
                'phone' => "0965443567887",
                'divisions_id' => 1,
                'position' => "Sekertaris",
            ],
            [
                'image' => "https://www.google.com/url?sa=i&url=https%3A%2F%2Fthebatik.co.id%2Fmodel-baju-seragam-batik-pegawai-bank%2F&psig=AOvVaw17KZd3RyQpdck7xaULXyXq&ust=1723549567870000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCNCqlNKw74cDFQAAAAAdAAAAABAJ",
                'name' => "Budi Haryono",
                'phone' => "0555443567887",
                'divisions_id' => 3,
                'position' => "Manager",
            ],
            [
                'image' => "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.virtualofficeku.co.id%2Fblog_posts%2F7-keuntungan-menjadi-seorang-karyawan%2F&psig=AOvVaw17KZd3RyQpdck7xaULXyXq&ust=1723549567870000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCNCqlNKw74cDFQAAAAAdAAAAABAR",
                'name' => "David Alson",
                'phone' => "0864243567887",
                'divisions_id' => 4,
                'position' => "Pegawai",
            ]
        ]);
    }
}