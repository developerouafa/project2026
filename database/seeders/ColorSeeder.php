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
            // Basic
            ['name' => 'Red',        'code' => '#FF0000'],
            ['name' => 'Blue',       'code' => '#0000FF'],
            ['name' => 'Green',      'code' => '#00FF00'],
            ['name' => 'Black',      'code' => '#000000'],
            ['name' => 'White',      'code' => '#FFFFFF'],
            ['name' => 'Yellow',     'code' => '#FFFF00'],

            // Neutral
            ['name' => 'Gray',       'code' => '#808080'],
            ['name' => 'Dark Gray',  'code' => '#4F4F4F'],
            ['name' => 'Light Gray', 'code' => '#D3D3D3'],
            ['name' => 'Beige',      'code' => '#F5F5DC'],
            ['name' => 'Ivory',      'code' => '#FFFFF0'],

            // Warm colors
            ['name' => 'Orange',     'code' => '#FFA500'],
            ['name' => 'Brown',      'code' => '#8B4513'],
            ['name' => 'Maroon',     'code' => '#800000'],
            ['name' => 'Gold',       'code' => '#FFD700'],
            ['name' => 'Coral',      'code' => '#FF7F50'],

            // Cool colors
            ['name' => 'Navy',       'code' => '#000080'],
            ['name' => 'Teal',       'code' => '#008080'],
            ['name' => 'Turquoise',  'code' => '#40E0D0'],
            ['name' => 'Cyan',       'code' => '#00FFFF'],
            ['name' => 'Mint',       'code' => '#98FF98'],

            // Purple & Pink
            ['name' => 'Purple',     'code' => '#800080'],
            ['name' => 'Violet',     'code' => '#8A2BE2'],
            ['name' => 'Lavender',   'code' => '#E6E6FA'],
            ['name' => 'Pink',       'code' => '#FFC0CB'],
            ['name' => 'Magenta',    'code' => '#FF00FF'],
        ];

        foreach ($colors as $color) {
            Colors::create($color);
        }
    }
}
