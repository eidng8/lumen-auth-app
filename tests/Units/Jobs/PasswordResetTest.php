<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\Units\Jobs;

use App\Jobs\PasswordReset;
use Illuminate\Log\LogManager;
use Mockery;
use Tests\TestCase;

/**
 * Tests PasswordReset jobs.
 */
class PasswordResetTest extends TestCase
{
    public function testHandle()
    {
        // We haven't enabled facades, so manual mocking is required.
        // Use `Log::shouldReceive()` if facades are enabled.
        $mock = Mockery::mock(LogManager::class);
        app()->instance('log', $mock);
        $mock->shouldReceive('warning')
            ->with(
                'A password reset is requested. Please add you implementation.'
            );
        $job = new PasswordReset('someone@example.com');
        $job->handle();
    }
}
