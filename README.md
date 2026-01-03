# Filament Userback Plugin

A Filament plugin for integrating [Userback](https://userback.io) feedback widget.

![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/coddin-web/filament-userback-plugin?utm_source=oss&utm_medium=github&utm_campaign=coddin-web%2Ffilament-userback-plugin&labelColor=171717&color=FF570A&link=https%3A%2F%2Fcoderabbit.ai&label=CodeRabbit+Reviews)

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
