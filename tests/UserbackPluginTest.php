<?php

declare(strict_types=1);

use CoddinWeb\FilamentUserback\UserbackPlugin;

it('can be instantiated', function () {
    $plugin = UserbackPlugin::make();

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('has the correct plugin id', function () {
    $plugin = UserbackPlugin::make();

    expect($plugin->getId())->toBe('userback');
});

it('can set access token', function () {
    $plugin = UserbackPlugin::make()
        ->accessToken('test-token');

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('can set user data callback', function () {
    $plugin = UserbackPlugin::make()
        ->userDataUsing(fn () => ['id' => 1, 'name' => 'Test']);

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('can set only authenticated', function () {
    $plugin = UserbackPlugin::make()
        ->onlyAuthenticated(true);

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('can disable only authenticated', function () {
    $plugin = UserbackPlugin::make()
        ->onlyAuthenticated(false);

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('can set guard', function () {
    $plugin = UserbackPlugin::make()
        ->guard('admin');

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});

it('can chain all configuration methods', function () {
    $plugin = UserbackPlugin::make()
        ->accessToken('test-token')
        ->userDataUsing(fn () => ['id' => 1])
        ->onlyAuthenticated(true)
        ->guard('web');

    expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
});
