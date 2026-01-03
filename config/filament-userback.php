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
];
