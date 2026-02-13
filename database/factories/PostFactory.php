<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(),
            'published_at' => now(),
            'user_id' => User::factory(),      // crea un usuario automáticamente
            'category_id' => Category::factory(), // crea una categoría automáticamente
        ];
    }
}
