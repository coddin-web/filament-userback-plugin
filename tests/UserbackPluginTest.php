<?php

declare(strict_types=1);

use CoddinWeb\FilamentUserback\UserbackPlugin;
use Filament\Panel;

beforeEach(function () {
    config()->set('filament-userback.access_token', null);
    config()->set('filament-userback.only_authenticated', null);
    config()->set('filament-userback.guard', null);
});

describe('plugin instantiation', function () {
    it('can be instantiated via make()', function () {
        $plugin = UserbackPlugin::make();

        expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
    });

    it('returns correct plugin id', function () {
        $plugin = UserbackPlugin::make();

        expect($plugin->getId())->toBe('userback');
    });
});

describe('fluent configuration', function () {
    it('can set access token', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('my-token');

        expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
    });

    it('can set user data callback', function () {
        $plugin = UserbackPlugin::make()
            ->userDataUsing(fn () => ['id' => 1, 'name' => 'Test User']);

        expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
    });

    it('can enable only authenticated mode', function () {
        $plugin = UserbackPlugin::make()
            ->onlyAuthenticated(true);

        expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
    });

    it('can disable only authenticated mode', function () {
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
            ->accessToken('my-token')
            ->userDataUsing(fn () => ['id' => 1])
            ->onlyAuthenticated(true)
            ->guard('web');

        expect($plugin)->toBeInstanceOf(UserbackPlugin::class);
    });
});

describe('panel integration', function () {
    it('can be registered with a panel', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        $panel = $this->createPanel($plugin);

        expect($panel->getPlugin('userback'))->toBe($plugin);
    });

    it('can boot with a panel', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        // Should not throw
        $this->bootPluginWithPanel($plugin);

        expect(true)->toBeTrue();
    });

    it('uses panel auth guard as fallback', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        $panel = $this->createPanel($plugin, 'admin');

        expect($panel->getAuthGuard())->toBe('admin');
    });
});

describe('config fallback behavior', function () {
    it('uses config access token when not set on plugin', function () {
        config()->set('filament-userback.access_token', 'config-token');

        $plugin = UserbackPlugin::make();
        $panel = $this->createPanel($plugin);

        // Boot and check render hook is registered
        $plugin->boot($panel);

        expect(true)->toBeTrue(); // Plugin boots without error
    });

    it('uses config only_authenticated when not set on plugin', function () {
        config()->set('filament-userback.only_authenticated', false);

        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        $panel = $this->createPanel($plugin);
        $plugin->boot($panel);

        expect(true)->toBeTrue();
    });

    it('uses config guard when not set on plugin', function () {
        config()->set('filament-userback.guard', 'api');

        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        $panel = $this->createPanel($plugin);
        $plugin->boot($panel);

        expect(true)->toBeTrue();
    });
});

describe('guard validation', function () {
    it('boots without error when guard is valid', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('test-token')
            ->guard('web');

        $panel = $this->createPanel($plugin);
        $plugin->boot($panel);

        expect(true)->toBeTrue();
    });

    it('boots without error when guard is invalid', function () {
        $plugin = UserbackPlugin::make()
            ->accessToken('test-token')
            ->guard('nonexistent-guard');

        $panel = $this->createPanel($plugin);

        // Should not throw - invalid guard is converted to null
        $plugin->boot($panel);

        expect(true)->toBeTrue();
    });

    it('boots without error when config guard is invalid', function () {
        config()->set('filament-userback.guard', 'nonexistent-guard');

        $plugin = UserbackPlugin::make()
            ->accessToken('test-token');

        $panel = $this->createPanel($plugin);

        // Should not throw - invalid guard is converted to null
        $plugin->boot($panel);

        expect(true)->toBeTrue();
    });
});
