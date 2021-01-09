<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\Units\Http\Controllers;

use Laravel\Lumen\Routing\Router;
use Tests\AuthTestCase;

/**
 * Tests token services.
 */
class TokenControllerTest extends AuthTestCase
{
    public function test_refresh_ok(): void
    {
        $token = $this->getToken();
        $res = $this->sendRequest($token, '/refresh');
        $res->assertResponseOk();
        $res->seeJsonContains(['token_type' => 'bearer', 'expires_in' => 3600]);
        $this->assertStringContainsString(
            '"token":',
            $res->response->getContent()
        );
        $newToken = $res->response->getOriginalContent()['token'];
        $this->assertNotEquals($token, $newToken);
        // JWTGuard is a singleton, so it won't pick up authorization headers
        // from subsequent requests. We have to refresh the application to clear
        // all provider resolutions.
        $this->refreshApplication();
        $this->sendRequest($newToken, '/refresh')
            ->assertResponseOk();
    }

    public function test_logout_ok(): void
    {
        $token = $this->getToken();

        $this->app->router->group(
            ['middleware' => 'auth'],
            function (Router $router) {
                $router->post(
                    '/test',
                    function () {
                        return response()->json('ok');
                    }
                );
            }
        );

        $this->sendRequest($token, '/test')->assertResponseOk();
        $this->sendRequest($token, '/logout')->assertResponseOk();
        $this->sendRequest($token, '/test')->assertResponseStatus(401);
    }
}
