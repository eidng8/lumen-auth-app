<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace Tests\Units\Http\Controllers;

use App\Http\Controllers\AuthController;
use Tests\TestCase;

/**
 * Tests token services.
 */
class TokenControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['jwt.accepted_issuers' => ['http://localhost/login']]);
    }


    public function test_refresh_ok(): void
    {
        // Retrieve a token first
        $token = $this->post(
            '/login',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->response->getOriginalContent()['token'];

        // Post the token using authorization header.
        $res = $this->post(
            '/refresh',
            [],
            ['Authorization' => "bearer $token"]
        );
        $res->assertResponseOk();
        $res->seeJsonContains(['token_type' => 'bearer', 'expires_in' => 3600]);
        $this->assertStringContainsString(
            '"token":',
            $res->response->getContent()
        );
        $this->assertNotEquals(
            $token,
            $res->response->getOriginalContent()['token']
        );
    }

    public function test_refresh_without_token_returns_401(): void
    {
        $this->post('/refresh')->assertResponseStatus(401);
    }

    public function test_refresh_with_wrong_issuer_returns_401(): void
    {
        // the `iss` claim is the end point URL
        $this->app->router->post('login1', AuthController::class . '@login');
        // Retrieve a token first
        $token = $this->post(
            '/login1',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->response->getOriginalContent()['token'];

        // Post the token using authorization header.
        $this->post(
            '/refresh',
            [],
            ['Authorization' => "wrong_type $token"]
        )->assertResponseStatus(401);
    }

    public function test_refresh_with_wrong_token_type_returns_401(): void
    {
        // Retrieve a token first
        $token = $this->post(
            '/login',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->response->getOriginalContent()['token'];

        // Post the token using authorization header.
        $this->post(
            '/refresh',
            [],
            ['Authorization' => "wrong_type $token"]
        )->assertResponseStatus(401);
    }
}
