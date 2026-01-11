<?php

namespace Database\Seeders;

use App\Models\Colors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $colors = [
            ['name' => 'Red',    'code' => '#FF0000'],
            ['name' => 'Blue',   'code' => '#0000FF'],
            ['name' => 'Green',  'code' => '#00FF00'],
            ['name' => 'Black',  'code' => '#000000'],
            ['name' => 'White',  'code' => '#FFFFFF'],
            ['name' => 'Yellow', 'code' => '#FFFF00'],
        ];

        foreach ($colors as $color) {
            Colors::create($color);
        }
    }
}
