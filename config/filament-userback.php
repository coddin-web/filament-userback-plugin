<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Userback Access Token
    |--------------------------------------------------------------------------
    |
    | This is the access token for your Userback widget. You can find this
    | in your Userback dashboard under Settings > Widget.
    |
    | This token will be used as the default for all Filament panels unless
    | overridden per-panel using the ->accessToken() method on the plugin.
    |
    */

    'access_token' => env('USERBACK_ACCESS_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Only Authenticated Users
    |--------------------------------------------------------------------------
    |
    | When set to true, the Userback widget will only be rendered for
    | authenticated users. Set to false to show the widget to all visitors.
    |
    | This can be overridden per-panel using the ->onlyAuthenticated() method.
    |
    */

    'only_authenticated' => env('USERBACK_ONLY_AUTHENTICATED', true),

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | The authentication guard to use when checking if a user is authenticated.
    | If not set, it will fall back to the panel's configured auth guard.
    |
    | This can be overridden per-panel using the ->guard() method.
    |
    */

    'guard' => env('USERBACK_GUARD'),
];
