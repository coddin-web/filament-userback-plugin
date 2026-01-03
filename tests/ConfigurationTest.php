<?php

declare(strict_types=1);

it('uses access token from config when not set on plugin', function () {
    config()->set('filament-userback.access_token', 'config-token');

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getAccessToken');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make();
    $result = $method->invoke($plugin);

    expect($result)->toBe('config-token');
});

it('prefers plugin access token over config', function () {
    config()->set('filament-userback.access_token', 'config-token');

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getAccessToken');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make()
        ->accessToken('plugin-token');
    $result = $method->invoke($plugin);

    expect($result)->toBe('plugin-token');
});

it('returns null when no access token is configured', function () {
    config()->set('filament-userback.access_token', null);

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getAccessToken');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make();
    $result = $method->invoke($plugin);

    expect($result)->toBeNull();
});

it('uses only_authenticated from config when not set on plugin', function () {
    config()->set('filament-userback.only_authenticated', false);

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getOnlyAuthenticated');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make();
    $result = $method->invoke($plugin);

    expect($result)->toBeFalse();
});

it('prefers plugin only_authenticated over config', function () {
    config()->set('filament-userback.only_authenticated', true);

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getOnlyAuthenticated');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make()
        ->onlyAuthenticated(false);
    $result = $method->invoke($plugin);

    expect($result)->toBeFalse();
});

it('defaults only_authenticated to true', function () {
    config()->set('filament-userback.only_authenticated', null);

    $reflection = new ReflectionClass(\CoddinWeb\FilamentUserback\UserbackPlugin::class);
    $method = $reflection->getMethod('getOnlyAuthenticated');
    $method->setAccessible(true);

    $plugin = \CoddinWeb\FilamentUserback\UserbackPlugin::make();
    $result = $method->invoke($plugin);

    expect($result)->toBeTrue();
});
