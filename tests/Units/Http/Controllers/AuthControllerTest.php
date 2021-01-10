<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\Units\Http\Controllers;

use App\Jobs\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Mockery;
use stdClass;
use Tests\TestCase;

/**
 * Tests authentication services.
 */
class AuthControllerTest extends TestCase
{
    //region Registration tests
    public function test_register_ok(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $res = $this->post('/register', $post)
            ->seeInDatabase(
                'users',
                Arr::except($data, 'password_confirmation')
            );
        $fresh = User::whereEmail($user->email)->first()->toArray();
        ksort($fresh);
        $res->seeJsonContains(['user' => $fresh])
            ->assertResponseStatus(201);
    }

    public function test_register_duplicate_email_returns_422(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $this->post('/register', $post);
        $this->post('/register', $post)
            ->assertResponseStatus(422);
    }

    public function test_register_invalid_email_returns_422(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['email'] = 'invalid email';
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $this->post('/register', $post)
            ->assertResponseStatus(422);
    }

    public function test_register_unconfirmed_password_returns_422(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $this->post('/register', $post)
            ->assertResponseStatus(422);
    }

    public function test_register_relays_low_level_error(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $mockHash = Mockery::mock(new stdClass());
        $this->app->instance('hash', $mockHash);
        $mockHash->shouldReceive('make')
            ->once()
            ->andThrow(new Exception('just a test'));
        $res = $this->post('/register', $post);
        $res->assertResponseStatus(409);
        $this->assertStringContainsString(
            'just a test',
            $res->response->getContent()
        );
    }

    //endregion

    //region Login tests
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

    public function test_login_wrong_credential_returns_401(): void
    {
        $this->post(
            '/login',
            ['email' => 'not.exists@example.com', 'password' => 'some pass']
        )->assertResponseStatus(401);
    }

    public function test_login_invalid_email_returns_422(): void
    {
        $this->post(
            '/login',
            ['email' => 'not exists', 'password' => 'some pass']
        )->assertResponseStatus(422);
    }

    //endregion

    //region Password Reset
    public function test_password_reset_job_adds_to_queue(): void
    {
        $this->expectsJobs(PasswordReset::class);
        $this->post('password/reset', ['email' => 'someone@example.com'])
            ->assertResponseOk();
    }

    public function test_password_reset_invalid_email_returns_422(): void
    {
        $this->post('/password/reset', ['email' => 'invalid format'])
            ->assertResponseStatus(422);
    }

    public function test_password_reset_noe_exist_email_returns_422(): void
    {
        $this->post('/password/reset', ['email' => 'not.exists@example.com'])
            ->assertResponseStatus(422);
    }
    //endregion
}
