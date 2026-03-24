<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array {
        return [
            'title'     => fake()->sentence(),
            'body'      => fake()->paragraphs(3, true),
            'status'    => fake()->randomElement(['draft', 'published', 'archived']),
            'is_pinned' => fake()->boolean(15), // cca 15% pinned
        ];
    }

}
