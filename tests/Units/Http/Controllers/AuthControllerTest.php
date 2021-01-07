<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace Tests\Units\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * Tests authentication services
 */
class AuthControllerTest extends TestCase
{

    public function test_register_ok(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $this->post('/register', $post)
            ->seeInDatabase(
                'users',
                Arr::except($data, 'password_confirmation')
            )
            ->assertResponseStatus(201);
    }

    public function test_login_ok(): void
    {
        $res = $this->post(
            '/login',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->seeJsonContains(['token_type' => 'bearer', 'expires_in' => 3600]);
        $res->assertResponseOk();
        $this->assertStringContainsString(
            '"token":',
            $res->response->getContent()
        );
    }
}
