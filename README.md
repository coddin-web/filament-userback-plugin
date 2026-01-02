# Filament Userback Plugin

A Filament plugin for integrating [Userback](https://userback.io) feedback widget.

## Installation

```bash
composer require coddin-web/filament-userback-plugin
```

## Usage

Add the plugin to your Filament panel provider:

```php
use CoddinWeb\FilamentUserback\UserbackPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            UserbackPlugin::make()
                ->accessToken('your-userback-access-token')
                ->userDataUsing(fn () => [
                    'id' => auth()->id(),
                    'info' => [
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                    ],
                ]),
        ]);
}
```

## Configuration

### Access Token

Set your Userback access token:

```php
UserbackPlugin::make()
    ->accessToken('your-access-token')
```

### User Data

Optionally identify logged-in users by providing a callback:

```php
UserbackPlugin::make()
    ->userDataUsing(fn () => [
        'id' => auth()->id(),
        'info' => [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ],
    ])
```

## License

MIT License. See [LICENSE](LICENSE) for more information.
