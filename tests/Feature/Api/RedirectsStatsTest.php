<?php

namespace Tests\Feature\Api;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectsStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_total_accesses_count_all_logs()
    {
        $redirect = $this->createRedirectWithLogs();

        $respose = $this->getJson(route('redirects.stats', $redirect->code));

        $this->assertEquals(5, $respose->json('total_accesses'));
    }

    public function test_total_unique_accesses_count_logs_from_the_same_ip_as_one()
    {
        $redirect = $this->createRedirectWithLogs();

        $respose = $this->getJson(route('redirects.stats', $redirect->code));

        $this->assertEquals(2, $respose->json('total_unique_accesses'));
    }

    private function createRedirectWithLogs()
    {
        $logsData = [
            // 3 hits from the same IP
            [
                'ip_address' => '177.0.192.175',
                'referer' => 'https://laravel.com/otimeze',
            ],
            [
                'ip_address' => '177.0.192.175',
                'referer' => 'https://laravel.com/otimeze',
            ],
            [
                'ip_address' => '177.0.192.175',
                'referer' => 'https://laravel.com/otimeze',
            ],
            // 2 hits from the same IP
            [
                'ip_address' => '245.96.245.17',
                'referer' =>  'https://google.com/otimeze',
            ],
            [
                'ip_address' => '245.96.245.17',
                'referer' =>  'https://google.com/otimeze',
            ],
        ];

        return Redirect::factory()
            ->has(
                RedirectLog::factory()
                    ->count(count($logsData))
                    ->state(new Sequence(...$logsData)),
                'logs'
            )
            ->create();
    }
}
