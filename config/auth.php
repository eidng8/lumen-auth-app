<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        /**
         * This is one of the top level keys from the `guards` array below.
         */
        'guard' => 'api',

        /**
         * This is one of the top level keys from the `passwords` array below.
         */
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        /**
         * This is the name of the guard. This is the parameter passed while
         * calling functions/methods such as `Auth::guard('api')`.
         */
        'api' => [
            /**
             * This is the driver name from auth service providers, which is the
             * the first parameter to `Auth::extend()`. Here you could fill in
             * names of any built in drivers (e.g. `session`), third party
             * drivers, or your own drivers. This `jwt` driver is registered in
             * `Tymon\JWTAuth\Providers\AbstractServiceProvider::extendAuthGuard()`.
             * Which is inherited by `LaravelServiceProvider` and
             * `LumenServiceProvider`. And then added to either Laravel's
             * `config/app.php` or Lumen's `app.php` respectively.
             */
            'driver' => 'jwt',

            /**
             * This is one of the top level keys from the `providers` array below.
             */
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            /**
             * This is the driver name from user providers, which is the
             * the first parameter to `Auth::provider()`. Here you could fill in
             * names of any built in drivers (e.g. `eloquent`), third party
             * drivers, or your own drivers. For custom user providers, the call
             * to `Auth::provider()` can usually be found among its auth service
             * provider files, around calls to `Auth::extend()` maybe.
             * `jwt-auth` requires eloquent to operate, if you're wondering.
             */
            'driver' => 'eloquent',

            /**
             * This is the eloquent model class being used while retrieving
             * user data from database.
             */
            'model' => App\Models\User::class,

            /**
             * Say we want to use the `database` driver, then the returned
             * user will be an `Illuminate\Auth\GenericUser` instance instead
             * of eloquent user model. The two commented settings below should
             * be uncommented too.
             */
            // 'driver' => 'database',

            /**
             * This is one of the top level keys from the `connections` array in
             * `config/database.php`. Providing a `null` means using default
             * connection, defined by `default` in `config/database.php`.
             */
            // 'connection' => null,

            /**
             * Name of the database table that holds user credentials.
             */
            // 'table' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            /**
             * This is one of the top level keys from the `providers` array above.
             */
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,
];
