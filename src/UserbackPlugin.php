<?php

declare(strict_types=1);

namespace CoddinWeb\FilamentUserback;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;

class UserbackPlugin implements Plugin
{
    protected ?string $accessToken = null;

    protected ?bool $onlyAuthenticated = null;

    protected ?string $guard = null;

    protected ?Closure $userDataUsing = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'userback';
    }

    public function accessToken(string $accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function userDataUsing(?Closure $callback): static
    {
        $this->userDataUsing = $callback;

        return $this;
    }

    public function onlyAuthenticated(bool $onlyAuthenticated = true): static
    {
        $this->onlyAuthenticated = $onlyAuthenticated;

        return $this;
    }

    public function guard(?string $guard): static
    {
        $this->guard = $guard;

        return $this;
    }

    public function register(Panel $panel): void
    {
    }

    /**
     * Registers a render hook that injects the Userback view into the panel head.
     *
     * The hook renders the 'filament-userback::userback' view and provides it with
     * the resolved access token and user data.
     *
     * @param Panel $panel The panel instance being booted.
     */
    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): View => view(
                'filament-userback::userback',
                [
                    'accessToken' => $this->getAccessToken(),
                    'userData' => $this->getUserData(),
                    'onlyAuthenticated' => $this->getOnlyAuthenticated(),
                    'guard' => $this->getGuard($panel),
                ],
            ),
        );
    }

    /**
     * Retrieve the plugin access token.
     *
     * Returns the explicitly configured access token if set; otherwise returns the value from config('filament-userback.access_token').
     *
     * @return string|null The access token, or null if none is configured.
     */
    protected function getAccessToken(): ?string
    {
        if (\is_string($this->accessToken)) {
            return $this->accessToken;
        }

        $globalAccessToken = Config::get('filament-userback.access_token');
        if (\is_string($globalAccessToken)) {
            return $globalAccessToken;
        }

        return null;
    }

    protected function getOnlyAuthenticated(): bool
    {
        if (\is_bool($this->onlyAuthenticated)) {
            return $this->onlyAuthenticated;
        }

        $configValue = Config::get('filament-userback.only_authenticated');

        return \is_bool($configValue) ? $configValue : true;
    }

    protected function getGuard(Panel $panel): ?string
    {
        $guard = null;

        if (\is_string($this->guard)) {
            $guard = $this->guard;
        } elseif (\is_string($configGuard = Config::get('filament-userback.guard'))) {
            $guard = $configGuard;
        } else {
            $guard = $panel->getAuthGuard();
        }

        return $this->isValidGuard($guard) ? $guard : null;
    }

    protected function isValidGuard(?string $guard): bool
    {
        if ($guard === null) {
            return true;
        }

        $guards = Config::get('auth.guards', []);

        return \is_array($guards) && \array_key_exists($guard, $guards);
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getUserData(): ?array
    {
        if ($this->userDataUsing === null) {
            return null;
        }

        return ($this->userDataUsing)();
    }
}