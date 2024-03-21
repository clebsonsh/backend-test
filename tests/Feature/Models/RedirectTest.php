<?php

namespace Tests\Feature\Models;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_has_code_attribute()
    {
        $redirect = Redirect::factory()->create();

        $this->assertIsString($redirect->code);
        $this->assertEquals(Hashids::encode($redirect->id), $redirect->code);
    }

    public function test_redirects_can_have_status_active()
    {
        $redirect = Redirect::factory()->create(['status' => Redirect::STATUS_ACTIVE]);

        $this->assertIsString($redirect->status);
        $this->assertTrue($redirect->isActive());
    }

    public function test_redirects_can_have_status_inactive()
    {
        $redirect = Redirect::factory()->create(['status' => Redirect::STATUS_INACTIVE]);

        $this->assertIsString($redirect->status);
        $this->assertFalse($redirect->isActive());
    }

    public function test_redirects_has_logs()
    {
        $redirect = Redirect::factory()
            ->has(RedirectLog::factory()->count(3), 'logs')
            ->create();

        $this->assertCount(3, $redirect->logs);
        $this->assertContainsOnlyInstancesOf(RedirectLog::class, $redirect->logs);
    }
}
