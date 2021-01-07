<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\Units\Http\Middleware;

use Tests\AuthTestCase;

/**
 * Tests authentication middleware.
 */
class AuthenticateTest extends AuthTestCase
{

    public function test_authorization_header_ok(): void
    {
        // Post the token using authorization header.
        $res = $this->post(
            '/refresh',
            [],
            ['Authorization' => "bearer {$this->getToken()}"]
        );
        $res->assertResponseOk();
    }

    public function test_empty_accepted_issuer_allows_all(): void
    {
        config(['jwt.issuer' => 'wrong-issuer']);
        config(['jwt.accepted_issuers' => []]);
        $res = $this->post(
            '/refresh',
            [],
            ['Authorization' => "bearer {$this->getToken()}"]
        );
        $res->assertResponseOk();
    }

    public function test_no_authorization_header_returns_401(): void
    {
        $this->post('/refresh')->assertResponseStatus(401);
    }

    public function test_wrong_issuer_returns_401(): void
    {
        config(['jwt.issuer' => 'wrong-issuer']);
        $this->post(
            '/refresh',
            [],
            ['Authorization' => "bearer {$this->getToken()}"]
        )->assertResponseStatus(401);
    }

    public function test_wrong_token_type_returns_401(): void
    {
        $this->post(
            '/refresh',
            [],
            ['Authorization' => "wrong_type {$this->getToken()}"]
        )->assertResponseStatus(401);
    }

    public function test_token_in_query_string_returns_401(): void
    {
        $this->post("/refresh?token={$this->getToken()}")
             ->assertResponseStatus(401);
    }
}
