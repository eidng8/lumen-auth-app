<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests;

/**
 * Base class for auth unit tests.
 */
abstract class AuthTestCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        config(['jwt.issuer' => 'eidng8']);
        config(['jwt.accepted_issuers' => ['eidng8']]);
    }

    /**
     * Get a token from the given end point.
     *
     * @param  string  $endpoint
     *
     * @return string
     */
    protected function getToken($endpoint = '/login'): string
    {
        return $this->post(
            $endpoint,
            ['email' => 'someone@example.com', 'password' => '111111']
        )->response->getOriginalContent()['token'];
    }

    /**
     * Send a request to the given end point, with authorization header.
     *
     * @param  string  $token
     * @param  string  $endpoint
     * @param  array  $data
     * @param  string  $method
     * @param  array  $headers
     *
     * @return static
     */
    protected function sendRequest(
        string $token,
        string $endpoint,
        array $data = [],
        string $method = 'POST',
        array $headers = []
    ): static {
        $headers = array_merge(
            $headers,
            ['Authorization' => "bearer $token}"]
        );
        return $this->json($method, $endpoint, $data, $headers);
    }
}
