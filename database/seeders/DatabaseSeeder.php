<?php

namespace Database\Seeders;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Redirect::factory()
            ->has(RedirectLog::factory()->count(random_int(40, 50)), 'logs')
            ->create();
        Redirect::factory()
            ->has(RedirectLog::factory()->count(random_int(40, 50)), 'logs')
            ->create();
        Redirect::factory()
            ->has(RedirectLog::factory()->count(random_int(40, 50)), 'logs')
            ->create();
        Redirect::factory()
            ->has(RedirectLog::factory()->count(random_int(40, 50)), 'logs')
            ->create();
        Redirect::factory()
            ->has(RedirectLog::factory()->count(random_int(40, 50)), 'logs')
            ->create();

        Redirect::factory(5)
            ->has(RedirectLog::factory()->count(random_int(10, 20)), 'logs')
            ->create();
        Redirect::factory(5)
            ->has(RedirectLog::factory()->count(random_int(20, 40)), 'logs')
            ->create();
        Redirect::factory(5)
            ->has(RedirectLog::factory()->count(random_int(10, 50)), 'logs')
            ->create();
    }
}
