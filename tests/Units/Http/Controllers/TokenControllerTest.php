<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace Tests\Units\Http\Controllers;

use Tests\TestCase;

class TokenControllerTest extends TestCase
{

    public function testRefresh(): void
    {
        $token = $this->post(
            '/login',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->response->getOriginalContent()['token'];
        $res = $this->post(
            '/refresh',
            [],
            ['Authorization' => "bearer $token"]
        )->seeJsonContains(['token_type' => 'bearer', 'expires_in' => 3600]);
        $res->assertResponseOk();
        $this->assertStringContainsString(
            '"token":',
            $res->response->getContent()
        );
    }
}
