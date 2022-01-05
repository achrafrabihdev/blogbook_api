<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title =  $this->faker->sentence();
        return [
            'title' => $title,
            'content' => $this->faker->text(),
            'image' => 'posts/6zrVSr7OSV0SvnOoRHyqmnE3lL4r7a7EWOqmyIoe.jpg',
            'slug' => Str::slug($title,'-'),
            'nbr_views' => 0
        ];
    }
}
