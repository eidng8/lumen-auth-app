<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace Tests\Units\Claims;

use Tests\TestCase;

/**
 * Tests issuer claim.
 */
class IssuerTest extends TestCase
{
    public function test_wrong_issuer_returns_403(): void
    {
        config(['jwt.issuer' => 'wrong-issuer']);
        config(['jwt.accepted_issuers' => ['eidng8']]);
        $this->post(
            '/login',
            ['email' => 'someone@example.com', 'password' => '111111']
        )->seeJsonContains(
            ['message' => 'Invalid value provided for claim [iss]']
        )->seeStatusCode(403);
    }
}
