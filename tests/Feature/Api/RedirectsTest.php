<?php

namespace Tests\Feature\Api;

use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_redirect_with_valid_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'https://www.google.com',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('message', 'Redirect created');

        $this->assertCount(1, Redirect::all());
    }

    public function test_create_redirect_with_valid_url_with_query_params()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'https://www.google.com?test=1&test2=2',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('message', 'Redirect created');

        $this->assertCount(1, Redirect::all());
    }

    public function test_update_redirect_with_valid_url()
    {
        $url = 'https://www.google.com';
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => $url,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Redirect updated');

        $redirects = Redirect::all();
        $this->assertCount(1, $redirects);
        $this->assertEquals($url, $redirects->first()->url);
    }

    public function test_update_redirect_with_valid_url_with_query_params()
    {
        $url = 'https://www.google.com?test=1&test2=2';
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => $url,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Redirect updated');

        $redirects = Redirect::all();
        $this->assertCount(1, $redirects);
        $this->assertEquals($url, $redirects->first()->url);
    }

    public function test_fail_to_create_redirect_with_invalid_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'invalid-url',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL is not valid.');

        $this->assertCount(0, Redirect::all());
    }

    public function test_fail_to_create_redirect_with_app_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => config('app.url'),
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must be different from the server URL.');

        $this->assertCount(0, Redirect::all());
    }

    public function test_fail_to_create_redirect_with_non_https_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'http://www.google.com',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must use the HTTPS protocol.');

        $this->assertCount(0, Redirect::all());
    }

    public function test_fail_to_create_redirect_with_offline_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'https://www.google.com/not-found',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must be online.');

        $this->assertCount(0, Redirect::all());
    }

    public function test_fail_to_create_redirect_with_null_query_params()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'https://www.google.com?param1=value1&param2=',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must not have null query parameters.');

        $this->assertCount(0, Redirect::all());
    }

    public function test_fail_to_update_redirect_with_invalid_url()
    {
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => 'invalid-url',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL is not valid.');

        $this->assertCount(1, Redirect::all());
    }

    public function test_fail_to_update_redirect_with_app_url()
    {
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => config('app.url'),
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must be different from the server URL.');

        $this->assertCount(1, Redirect::all());
    }

    public function test_fail_to_update_redirect_with_non_https_url()
    {
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => 'http://www.google.com',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must use the HTTPS protocol.');

        $this->assertCount(1, Redirect::all());
    }

    public function test_fail_to_update_redirect_with_offline_url()
    {
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => 'https://www.google.com/not-found',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must be online.');

        $this->assertCount(1, Redirect::all());
    }

    public function test_fail_to_update_redirect_with_null_query_params()
    {
        $redirect = Redirect::factory()->create(['url' => 'https://www.example.com']);

        $response = $this->put(route('redirects.update', $redirect->code), [
            'url' => 'https://www.google.com?param1=value1&param2=',
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'The URL must not have null query parameters.');

        $this->assertCount(1, Redirect::all());
    }
}
