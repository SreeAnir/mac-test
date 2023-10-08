<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeNames = ['Red', 'Blue', 'Green', 'Yellow', 'Purple'];
        foreach ($sizeNames as $sizeName) {
            DB::table('colors')->insert([
                'name' => $sizeName,
            ]);
        }
    }
}
