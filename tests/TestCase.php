<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

/**
 * Unit test base class.
 */
abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
