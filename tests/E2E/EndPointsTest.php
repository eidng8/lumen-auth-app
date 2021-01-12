<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

/* @noinspection PhpUnhandledExceptionInspection PhpDocMissingThrowsInspection PhpArrayUsedOnlyForWriteInspection */

namespace Tests\E2E;

use Dotenv\Dotenv;
use Exception;
use Faker\Factory;
use Faker\Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Arr;
use PDO;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test all endpoints via HTTP. The `TEST_REMOTE_BASE` environment variable can
 * be used to set remote service base URL (defaults to `http://localhost:8000`).
 *
 * @template TUser = [
 *                       'id' => 123,
 *                       'name' => 'name',
 *                       'email' => 'email',
 *                       'password' => 'password'
 *                   ]
 * @template TPayload = [
 *                          'iss' => '$issuer',
 *                          'iat' => 123,
 *                          'exp' => 123,
 *                          'nbf' => 123,
 *                          'jti' => '$jti',
 *                          'sub' => 123,
 *                      ]
 * @template TResponse = [
 *                          'token' => '$token',    // newly generated token
 *                          'token_type' => 'bearer',
 *                          'expires_in' => 123,
 *                          'user_id' => 123,
 *                          'token_payload' => TPayload,    // new token payload
 *                          'auth' => '$token', // token sent in request
 *                          'auth_payload' => TPayload, // auth token payload
 *                       ]
 * @template TPromise<T> = [
 *                              'state' => 'fulfilled' | 'rejected',
 *                              'value' => T,
 *                         ]
 *
 * @group e2e
 */
class EndPointsTest extends TestCase
{
    protected static string $base;

    protected static Client $http;

    protected static Generator $faker;

    /**
     * List of all registered users.
     *
     * @var array<string,array{name:string,email:string,password:string}>
     */
    protected array $users = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::loadEnv(dirname(dirname(__DIR__)));

        static::$base = getenv('TEST_REMOTE_BASE')
            ?: $_ENV['TEST_REMOTE_BASE'] ?? 'http://localhost:8000';
        static::$http = new Client(['base_uri' => static::$base]);
        static::$faker = Factory::create();

        $db = getenv('DB_DATABASE') ?: $_ENV['DB_DATABASE'];
        if (empty($db)) {
            throw new Exception(
                '`DB_DATABASE` environment variable must points to database file.'
            );
        }
        $pdo = new PDO("sqlite:$db");
        $pdo->exec('delete from users where id>1');
    }

    protected static function loadEnv(string $base): void
    {
        Dotenv::createImmutable($base)->load();
    }

    /**
     * @return TUser[]
     */
    public function test_register_ok(): array
    {
        $requests = [];
        for ($i = 0; $i < 10; $i++) {
            $requests += $this->register();
        }
        /* @noinspection PhpUnhandledExceptionInspection */
        /* @var TUser[] $responses */
        $responses = Utils::unwrap($requests);
        foreach ($responses as $name => $json) {
            /* @var array{name:string,email:string,password:string} $json */
            self::assertArrayHasKey('user', $json);
            self::assertEquals($name, $json['user']['name']);
            self::assertEquals($name, $this->users[$name]['name']);
            $this->users[$name]['id'] = $json['user']['id'];
        }

        return $this->users;
    }

    /**
     * @depends test_register_ok
     *
     * @param  TUser[]  $users
     *
     * @return array [ TUser[], array<string,string> ]
     */
    public function test_login_ok(array $users): array
    {
        /* @var array<string,string> $tokens */
        $tokens = [];
        $requests = [];
        foreach ($users as $name => $user) {
            $requests[$name] = $this->login($user['email'], $user['password']);
        }
        /* @noinspection PhpUnhandledExceptionInspection */
        /* @var TResponse[] $responses */
        $responses = Utils::unwrap($requests);
        foreach ($responses as $name => $json) {
            self::assertEquals($json['token_payload']['sub'], $json['user_id']);
            self::assertEquals($users[$name]['id'], $json['user_id']);
            $tokens[$name] = $json['token'];
        }

        return [$users, $tokens];
    }

    /**
     * @depends test_login_ok
     *
     * @param  array  $inputs  = [ TUser[], array<string,string> ]
     *
     * @return array [ TUser[], array<string,string> ]
     */
    public function test_token_services_ok(array $inputs): array
    {
        $sent = [];
        $requests = [];
        $endpoints = ['verify', 'heartbeat'];
        $em = count($endpoints) - 1;
        [$users, $tokens] = $inputs;
        for ($i = 0; $i < 10; $i++) {
            foreach ($users as $name => $user) {
                $ei = rand(0, $em);
                $endpoint = $endpoints[$ei];
                $token = $tokens[$name];
                $requests["$name:$i"] = call_user_func(
                    [$this, $endpoint],
                    $token
                );
                $sent["$name:$i"] = [$endpoints[$ei], $user['id'], $token];
            }
        }
        $promises = Utils::settle($requests)->wait();
        foreach ($promises as $idx => $promise) {
            [$endpoint, $userId, $token] = $sent[$idx];
            if ('fulfilled' != $promise['state']) {
                static::fail(
                    "request[$idx] `$endpoint` was failed: with {$promise['reason']->getMessage()}"
                );
            }
            self::assertEquals(
                $promise['value']['auth_payload']['sub'],
                $promise['value']['user_id']
            );
            self::assertEquals($userId, $promise['value']['user_id']);
            self::assertEquals($token, $promise['value']['auth']);
        }

        return $inputs;
    }

    /**
     * @depends test_token_services_ok
     *
     * @param  array  $inputs  = [ TUser[], array<string,string> ]
     */
    public function test_refresh_ok(array $inputs)
    {
        $oldTokens = [];
        $requests = [];
        $blacklist = [];
        [$users, $tokens] = $inputs;
        for ($i = 0; $i < 10; $i++) {
            $sent = [];
            $oldTokens[] = $tokens;
            foreach ($tokens as $name => $token) {
                $sent[$name] = $token;
                $requests[$name] = $this->refresh($name, $tokens, $blacklist);
            }
            /* @var TResponse[] $promises */
            $promises = Utils::unwrap($requests);
            foreach ($promises as $name => $promise) {
                self::assertEquals($users[$name]['id'], $promise['user_id']);
            }
            $this->test_token_services_ok([$users, $tokens]);
        }
    }

    /**
     * @param  ResponseInterface  $response
     * @param  string[]  $keys
     *
     * @return string[]
     */
    protected function extractToken(
        ResponseInterface $response,
        array $keys = ['token']
    ): array {
        $content = $response->getBody()->getContents();
        $json = json_decode($content, true);
        foreach ($keys as $key) {
            self::assertArrayHasKey($key, $json);
        }

        return array_values(Arr::only($json, $keys));
    }

    /**
     * @return array<string,PromiseInterface>
     */
    protected function register(): array
    {
        $user = [
            'name' => static::$faker->unique()->userName,
            'email' => static::$faker->unique()->safeEmail,
            'password' => static::$faker->password,
        ];
        $this->users[$user['name']] = $user;

        return [
            $user['name'] => static::$http->postAsync(
                '/register',
                [
                    'json' => array_merge(
                        $user,
                        ['password_confirmation' => $user['password']]
                    ),
                ]
            )->then(
                function (ResponseInterface $response) {
                    return json_decode(
                        $response->getBody()->getContents(),
                        true
                    );
                }
            ),
        ];
    }

    protected function login(string $user, string $pass): PromiseInterface
    {
        return static::$http->postAsync(
            '/login',
            ['json' => ['email' => $user, 'password' => $pass]]
        )->then(
            function (ResponseInterface $response) {
                return json_decode($response->getBody()->getContents(), true);
            }
        );
    }

    protected function refresh(
        string $name,
        array &$tokens,
        array &$blacklist
    ): PromiseInterface {
        return static::$http->postAsync(
            '/refresh',
            ['headers' => ['Authorization' => "bearer {$tokens[$name]}"]]
        )->then(
            function (ResponseInterface $response) use (
                $name,
                &$tokens,
                &$blacklist
            ) {
                self::assertEquals(200, $response->getStatusCode());
                $blacklist[] = $tokens[$name];
                $json = json_decode($response->getBody()->getContents(), true);
                $tokens[$name] = $json['token'];

                return $json;
            }
        );
    }

    protected function verify(string $token): PromiseInterface
    {
        return static::$http->postAsync(
            '/verify',
            ['headers' => ['Authorization' => "bearer $token"]]
        )->then(
            function (ResponseInterface $response) {
                return json_decode($response->getBody()->getContents(), true);
            }
        );
    }

    protected function heartbeat(string $token): PromiseInterface
    {
        return static::$http->postAsync(
            '/heartbeat',
            ['headers' => ['Authorization' => "bearer $token"]]
        )->then(
            function (ResponseInterface $response) {
                return json_decode($response->getBody()->getContents(), true);
            }
        );
    }
}
