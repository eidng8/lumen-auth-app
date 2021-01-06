<?php

namespace Tests\Units\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function testRegisterOk(): void
    {
        $user = User::factory()->make();
        $post = $data = $user->toArray();
        $post['password'] = $user->password;
        $post['password_confirmation'] = $user->password;
        $this->post('/api/register', $post)
            ->seeInDatabase(
                'users',
                Arr::except($data, 'password_confirmation')
            );
    }
}
