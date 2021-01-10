<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Claims;

use Tymon\JWTAuth\Exceptions\InvalidClaimException;

/**
 * Issuer claim class that has extra constrain on values.
 */
class Issuer extends \Tymon\JWTAuth\Claims\Issuer
{
    /**
     * @return bool
     * @throws InvalidClaimException
     */
    public function validatePayload(): bool
    {
        // If `.env` sets `JWT_ACCEPTED_ISSUERS=` (nothing follows the equal
        // sign), the `config()` call below returns differently on different
        // OS. It returns an empty array on Windows, even in WSL Ubuntu.
        // However it returns an array with one empty string (`['']`). We have
        // to explicitly deal with that. Allows all issuers if the configuration
        // is not set.
        $accepted = array_filter((array) config('jwt.accepted_issuers'));
        if (count($accepted) == 0 || in_array($this->getValue(), $accepted)) {
            return parent::validatePayload();
        }

        throw new InvalidClaimException($this);
    }
}
