<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Jobs;

/**
 * Password reset queue job scaffolding. Password reset could take various forms
 * in real world applications. Here we just demonstrate the first step of reset
 * process using email. One could simply utilize Laravel's reset password flow,
 * or design custom process flow.
 *
 * Check out official documents {@see https://laravel.com/docs/8.x/passwords} on
 * the subject.
 */
class PasswordReset extends Job
{
    public string $email;

    /**
     * Add/replace parameters to this class, so that it meets actual process
     * requirement.
     *
     * @param  string  $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // This is the first step of password reset process. One could send out
        // the password reset email. However, it may not be obvious here that
        // the actual email sending process is not performed during request
        // process. Instead, the bulk of process is performed by the queue
        // server, which is separated and in background.
        app('log')->warning(
            'A password reset is requested. Please add you implementation.'
        );
    }
}
