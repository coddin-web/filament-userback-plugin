<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

it('renders userback script when access token is provided', function () {
    $view = view('filament-userback::userback', [
        'accessToken' => 'test-token',
        'userData' => null,
        'onlyAuthenticated' => false,
        'guard' => null,
    ]);

    $html = $view->render();

    expect($html)
        ->toContain('Userback.access_token')
        ->toContain('test-token')
        ->toContain('static.userback.io/widget/v1.js');
});

it('does not render when access token is null', function () {
    $view = view('filament-userback::userback', [
        'accessToken' => null,
        'userData' => null,
        'onlyAuthenticated' => false,
        'guard' => null,
    ]);

    $html = $view->render();

    expect($html)->toBe('');
});

it('does not render when only_authenticated is true and user is not logged in', function () {
    Auth::shouldReceive('guard')->with(null)->andReturnSelf();
    Auth::shouldReceive('check')->andReturn(false);

    $view = view('filament-userback::userback', [
        'accessToken' => 'test-token',
        'userData' => null,
        'onlyAuthenticated' => true,
        'guard' => null,
    ]);

    $html = $view->render();

    expect($html)->toBe('');
});

it('renders when only_authenticated is true and user is logged in', function () {
    Auth::shouldReceive('guard')->with(null)->andReturnSelf();
    Auth::shouldReceive('check')->andReturn(true);

    $view = view('filament-userback::userback', [
        'accessToken' => 'test-token',
        'userData' => null,
        'onlyAuthenticated' => true,
        'guard' => null,
    ]);

    $html = $view->render();

    expect($html)->toContain('Userback.access_token');
});

it('renders user data when provided', function () {
    $view = view('filament-userback::userback', [
        'accessToken' => 'test-token',
        'userData' => ['id' => 123, 'info' => ['name' => 'John']],
        'onlyAuthenticated' => false,
        'guard' => null,
    ]);

    $html = $view->render();

    expect($html)
        ->toContain('Userback.user_data')
        ->toContain('123')
        ->toContain('John');
});

it('uses specified guard for auth check', function () {
    Auth::shouldReceive('guard')->with('admin')->andReturnSelf();
    Auth::shouldReceive('check')->andReturn(true);

    $view = view('filament-userback::userback', [
        'accessToken' => 'test-token',
        'userData' => null,
        'onlyAuthenticated' => true,
        'guard' => 'admin',
    ]);

    $html = $view->render();

    expect($html)->toContain('Userback.access_token');
});
