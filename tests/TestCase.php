<?php

declare(strict_types=1);

namespace CoddinWeb\FilamentUserback\Tests;

use CoddinWeb\FilamentUserback\FilamentUserbackServiceProvider;
use CoddinWeb\FilamentUserback\UserbackPlugin;
use Filament\FilamentServiceProvider;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\SupportServiceProvider;
use Illuminate\Foundation\Auth\User;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            SupportServiceProvider::class,
            FilamentUserbackServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function createPanel(UserbackPlugin $plugin, ?string $authGuard = null): Panel
    {
        $panel = Panel::make()
            ->id('test')
            ->path('test')
            ->plugin($plugin);

        if ($authGuard !== null) {
            $panel->authGuard($authGuard);
        }

        return $panel;
    }

    protected function bootPluginWithPanel(UserbackPlugin $plugin, ?string $authGuard = null): void
    {
        $panel = $this->createPanel($plugin, $authGuard);
        $plugin->boot($panel);
    }

    protected function renderUserbackView(
        ?string $accessToken,
        ?array $userData,
        bool $onlyAuthenticated,
        ?string $guard
    ): string {
        return view('filament-userback::userback', [
            'accessToken' => $accessToken,
            'userData' => $userData,
            'onlyAuthenticated' => $onlyAuthenticated,
            'guard' => $guard,
        ])->render();
    }
}
