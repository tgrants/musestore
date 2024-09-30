<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Piece;
use App\Models\Tag;
use App\Models\Type;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'admin',
            'admin' => true,
            'password' => 'admin',
        ]);

        // Create 50 non-admin users
        User::factory(50)->create([
            'admin' => false,
            'password' => 'test',
        ]);

        // Create media types
        $type_audio = Type::factory()->create(['name' => 'Audio']);
        $type_sheet = Type::factory()->create(['name' => 'Sheet music']);
        $type_musescore = Type::factory()->create(['name' => 'Muse Score']);

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
        $tags_instruments = collect($instruments)->map(function ($instrument) {
            return new Tag(['name' => $instrument]);
        });
        $category_instruments->tags()->saveMany($tags_instruments);

        // Pieces and items
        $piece1 = Piece::factory()->create(['name' => 'Piece 1']);
        $piece2 = Piece::factory()->create(['name' => 'Piece 2']);
        $piece3 = Piece::factory()->create(['name' => 'Piece 3']);

        // Create items linked to pieces and types
        $item1 = Item::factory()->create([
            'name' => 'Item 1',
            'filepath' => 'path/to/file1',
            'type_id' => $type_audio->id,
            'piece_id' => $piece1->id,
        ]);

        $item2 = Item::factory()->create([
            'name' => 'Item 2',
            'filepath' => 'path/to/file2',
            'type_id' => $type_sheet->id,
            'piece_id' => $piece2->id,
        ]);

        $item3 = Item::factory()->create([
            'name' => 'Item 3',
            'filepath' => 'path/to/file3',
            'type_id' => $type_musescore->id,
            'piece_id' => $piece3->id,
        ]);

        // Attach tags to pieces
        $tag1 = Tag::first(); // Assume the first tag in the database
        $tag2 = Tag::skip(1)->first(); // Assume the second tag in the database

        $piece1->tags()->attach([$tag1->id, $tag2->id]);
        $piece2->tags()->attach([$tag1->id]);
        $piece3->tags()->attach([$tag2->id]);
    }
}
