<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Redirect>
 */
class RedirectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $urls = collect([
            'https://laravel.com',
            'https://laracasts.com',
            'https://laravel-news.com',
            'https://larajobs.com',
            'https://facebook.com',
            'https://instagram.com',
            'https://google.com',
        ]);

        return [
            'url' => $urls->random(),
            'last_accessed_at' => now()->subDays(random_int(3, 10)),
            'created_at' => now()->subDays(random_int(30, 60)),
        ];
    }
}
