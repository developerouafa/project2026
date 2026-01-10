<?php

namespace Database\Seeders;

use App\Models\Sections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* Create section
        Sections::create([
            'name' => ['en' => 'sectionen1', 'ar' => 'sectionar1'],
            'user_id' => 1,
        ]);
        $section_id1 = Sections::latest()->first()->id;

        //* Create children section
        Sections::create([
            'name' => ['en' => 'childen1', 'ar' => 'childar1'],
            'parent_id' => $section_id1,
            'user_id' => 1,
        ]);

        //* Create section
        Sections::create([
            'name' => ['en' => 'sectionen2', 'ar' => 'sectionar2'],
            'user_id' => 1,
        ]);
        $section_id2 = Sections::latest()->first()->id;

        //* Create children section
        Sections::create([
            'name' => ['en' => 'childen2', 'ar' => 'childar2'],
            'parent_id' => $section_id2,
            'user_id' => 1,
        ]);


                //* Create section
        Sections::create([
            'name' => ['en' => 'sectionen3', 'ar' => 'sectionar3'],
            'user_id' => 1,
        ]);
        $section_id3 = Sections::latest()->first()->id;
        //* Create children section
        Sections::create([
            'name' => ['en' => 'childen3', 'ar' => 'childar3'],
            'parent_id' => $section_id3,
            'user_id' => 1,
        ]);


        //* Create section
        Sections::create([
            'name' => ['en' => 'sectionen4', 'ar' => 'sectionar4'],
            'user_id' => 1,
        ]);
        $section_id4 = Sections::latest()->first()->id;
        //* Create children section
        Sections::create([
            'name' => ['en' => 'childen4', 'ar' => 'childar4'],
            'parent_id' => $section_id4,
            'user_id' => 1,
        ]);


        //* Create section
        Sections::create([
            'name' => ['en' => 'sectionen5', 'ar' => 'sectionar5'],
            'user_id' => 1,
        ]);
        $section_id5 = Sections::latest()->first()->id;
        //* Create children section
        Sections::create([
            'name' => ['en' => 'childen5', 'ar' => 'childar5'],
            'parent_id' => $section_id5,
            'user_id' => 1,
        ]);
    }
}
