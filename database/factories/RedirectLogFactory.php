<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RedirectLog>
 */
class RedirectLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $urls = collect([
            'https://laravel.com/otimeze',
            'https://laracasts.com/otimeze',
            'https://laravel-news.com/otimeze',
            'https://larajobs.com/otimeze',
            'https://facebook.com/otimeze',
            'https://instagram.com/otimeze',
            'https://google.com/otimeze',
        ]);

        $ips = collect([
            "73.23.240.11",
            "93.168.129.117",
            "235.24.187.218",
            "245.8.71.196",
            "143.12.34.183",
            "245.96.245.17",
            "177.0.192.175",
            "89.191.215.163",
            "241.211.185.179",
            "242.208.173.156",
            "102.141.83.211",
            "51.244.9.216",
        ]);

        return [
            'redirect_id' => Redirect::factory(),
            'ip_address' => $ips->random(),
            'user_agent' => fake()->userAgent,
            'referer' => $urls->random(),
            'query_params' => http_build_query([
                fake()->word => fake()->word,
                fake()->word => fake()->word,
            ]),
            'created_at' => now()->subDays(random_int(1, 30))
        ];
    }
}
