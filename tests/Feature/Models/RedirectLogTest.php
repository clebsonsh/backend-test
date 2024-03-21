<?php

namespace Tests\Feature\Models;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_belongs_to_a_redirect()
    {
        $log = RedirectLog::factory()->create();

        $this->assertNotNull($log->redirect);
        $this->assertInstanceOf(Redirect::class, $log->redirect);
    }
}
