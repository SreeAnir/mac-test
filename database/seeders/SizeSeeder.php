<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeNames = ['Small', 'Medium', 'Large', 'XL', 'XXL'];
        foreach ($sizeNames as $sizeName) {
            DB::table('sizes')->insert([
                'name' => $sizeName,
            ]);
        }
    }
}
