<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\E2E;

use Dotenv\Dotenv;


/**
 * @group e2e
 */
class EndPointsSwooleTest extends EndPointsTest
{
    protected static function loadEnv(): void
    {
        parent::loadEnv();
        $base = dirname(dirname(__DIR__));
        if (file_exists("$base/.swoole.env")) {
            Dotenv::createImmutable($base, '.swoole.env')->load();
        }
    }
}