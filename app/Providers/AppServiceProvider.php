<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Providers;

use Tymon\JWTAuth\Http\Parser\AuthHeaders;
use Tymon\JWTAuth\Http\Parser\Parser;
use Tymon\JWTAuth\Providers\LumenServiceProvider;

/**
 * Application service provider.
 */
class AppServiceProvider extends LumenServiceProvider
{
    /**
     * Enables only the authorization header parser, so that the application
     * won't allow tokens passed by any other way, such as query string.
     */
    protected function registerTokenParser(): void
    {
        $this->app->singleton(
            'tymon.jwt.parser',
            function ($app) {
                $parser = new Parser($app['request'], [new AuthHeaders()]);
                $app->refresh('request', $parser, 'setRequest');

                return $parser;
            }
        );
    }
}
