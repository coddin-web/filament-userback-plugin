<?php

declare(strict_types=1);

use CoddinWeb\FilamentUserback\UserbackPlugin;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    // Reset config before each test
    config()->set('filament-userback.access_token', null);
    config()->set('filament-userback.only_authenticated', null);
    config()->set('filament-userback.guard', null);
});

describe('access token configuration', function () {
    it('renders widget when access token is set via config', function () {
        config()->set('filament-userback.access_token', 'config-token');

        $html = $this->renderUserbackView(
            accessToken: 'config-token',
            userData: null,
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)
            ->toContain('Userback.access_token')
            ->toContain('config-token');
    });

    it('renders widget when access token is set via plugin method', function () {
        $html = $this->renderUserbackView(
            accessToken: 'plugin-token',
            userData: null,
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)
            ->toContain('Userback.access_token')
            ->toContain('plugin-token');
    });

    it('does not render widget when no access token is configured', function () {
        $html = $this->renderUserbackView(
            accessToken: null,
            userData: null,
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)->toBe('');
    });
});

describe('only_authenticated configuration', function () {
    it('renders widget for unauthenticated users when only_authenticated is false', function () {
        Auth::shouldReceive('guard')->with(null)->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(false);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)->toContain('Userback.access_token');
    });

    it('does not render widget for unauthenticated users when only_authenticated is true', function () {
        Auth::shouldReceive('guard')->with(null)->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(false);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: true,
            guard: null
        );

        expect($html)->toBe('');
    });

    it('renders widget for authenticated users when only_authenticated is true', function () {
        Auth::shouldReceive('guard')->with(null)->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(true);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: true,
            guard: null
        );

        expect($html)->toContain('Userback.access_token');
    });
});

describe('guard configuration', function () {
    it('uses default guard when no guard is specified', function () {
        Auth::shouldReceive('guard')->with(null)->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(true);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: true,
            guard: null
        );

        expect($html)->toContain('Userback.access_token');
    });

    it('uses specified guard for auth check', function () {
        Auth::shouldReceive('guard')->with('admin')->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(true);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: true,
            guard: 'admin'
        );

        expect($html)->toContain('Userback.access_token');
    });

    it('respects guard auth state', function () {
        Auth::shouldReceive('guard')->with('admin')->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(false);

        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: true,
            guard: 'admin'
        );

        expect($html)->toBe('');
    });
});

describe('user data configuration', function () {
    it('renders user data when provided', function () {
        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: ['id' => 123, 'info' => ['name' => 'John Doe', 'email' => 'john@example.com']],
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)
            ->toContain('Userback.user_data')
            ->toContain('123')
            ->toContain('John Doe')
            ->toContain('john@example.com');
    });

    it('does not render user data when not provided', function () {
        $html = $this->renderUserbackView(
            accessToken: 'test-token',
            userData: null,
            onlyAuthenticated: false,
            guard: null
        );

        expect($html)
            ->toContain('Userback.access_token')
            ->not->toContain('Userback.user_data');
    });
});
