<?php

declare(strict_types=1);

namespace CoddinWeb\FilamentUserback;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;

class UserbackPlugin implements Plugin
{
    protected ?string $accessToken = null;

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

    public function register(Panel $panel): void
    {
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): View => view(
                'filament-userback::userback',
                [
                    'accessToken' => $this->getAccessToken(),
                    'userData' => $this->getUserData(),
                ],
            ),
        );
    }

    protected function getAccessToken(): ?string
    {
        return $this->accessToken ?? config('filament-userback.access_token');
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
