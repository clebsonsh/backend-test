<?php

namespace Tests\Feature\Web;

use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_query_params_pass_through()
    {
        $queryParamsData = [
            // To Do - Make this test pass
            // [
            //     'request' => 'utm_source=facebook',
            //     'redirect' => 'utm_campaign=ads',
            //     'expected' => 'utm_source=facebook&utm_campaign=ads'
            // ],

            [
                'request' => 'utm_source=instagram',
                'redirect' => 'utm_source=facebook&utm_campaign=ads',
                'expected' => 'utm_source=instagram&utm_campaign=ads'
            ],
            [
                'request' => 'utm_source=&utm_campaign=test',
                'redirect' => 'utm_source=facebook',
                'expected' => 'utm_source=facebook&utm_campaign=test'
            ],
        ];

        foreach ($queryParamsData as $data) {
            $domain = 'https://www.google.com?';

            $redirect = Redirect::factory()->create([
                'url' => $domain . $data['redirect'],
            ]);

            $response = $this->get('/r/' . $redirect->code . '?' . $data['request'], [
                'Accept' => 'application/json',
            ]);

            $response->assertStatus(302);
            $response->assertRedirect($domain . $data['expected']);
        }
    }
}
