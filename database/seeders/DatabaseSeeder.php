<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Type;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'admin',
            'email' => 'email@example.com',
            'admin' => true,
            'password' => 'admin',
        ]);

        // Create 50 non-admin users
        User::factory(50)->create([
            'admin' => false,
            'password' => 'test',
        ]);

        // Create media types
        Type::factory()->create(['name' => 'Audio']);
        Type::factory()->create(['name' => 'Sheet music']);
        Type::factory()->create(['name' => 'Muse Score']);

        // Create categories and tags
        // Grade
        $category_grade = Category::factory()->create(['name' => 'Grades']);
        $tags_grade = collect(range(1, 12))->map(function ($gradeNumber) {
            return new Tag(['name' => 'Grade ' . $gradeNumber]);
        });
        $category_grade->tags()->saveMany($tags_grade);

        // Scale
        $category_scale = Category::factory()->create(['name' => 'Scale']);
        $scales = [
            'C dur', 'a moll', 'G dur', 'e moll', 'D dur', 'b moll',
            'A dur', 'f# moll', 'E dur', 'c# moll', 'B dur', 'g# moll',
            'F# dur', 'd# moll', 'Db dur', 'bb moll', 'Ab dur', 'f moll',
            'Eb dur', 'c moll', 'Bb dur', 'g moll', 'F dur', 'd moll'
        ];
        $tags_scale = collect($scales)->map(function ($scale) {
            return new Tag(['name' => $scale]);
        });
        $category_scale->tags()->saveMany($tags_scale);

        // Instruments
        $category_instruments = Category::factory()->create(['name' => 'Instrument']);
        $instruments = [
            'flute', 'piano'
        ];
        /*
        $tags_instruments->tags()->saveMany([
            new Tag(['name' => '']),
        ]);
        */
        $tags_instruments = collect($instruments)->map(function ($instrument) {
            return new Tag(['name' => $instrument]);
        });
        $category_instruments->tags()->saveMany($tags_instruments);
    }
}
