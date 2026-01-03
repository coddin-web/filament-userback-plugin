# CLAUDE.md

This file provides guidance for Claude Code when working on this project.

## Project Overview

This is a Filament plugin that integrates the Userback widget into Filament panels. Userback is a customer feedback tool that adds a widget to collect user feedback.

## Project Structure

```txt
├── src/
│   ├── FilamentUserbackServiceProvider.php  # Laravel service provider
│   └── UserbackPlugin.php                   # Main Filament plugin class
├── config/
│   └── filament-userback.php               # Package configuration
├── resources/views/
│   └── userback.blade.php                  # Blade view for the widget script
└── composer.json                           # Package manifest
```

## Key Components

### UserbackPlugin.php
The main plugin class that implements `Filament\Contracts\Plugin`. It:
- Registers a render hook to inject the Userback script into the page head
- Accepts an `accessToken` (required for Userback)
- Accepts optional `userDataUsing` callback for user identification

### Configuration
The `accessToken` can be set:
1. **Globally** via `config/filament-userback.php` - applies to all panels
2. **Per-panel** via `->accessToken()` method - overrides global config

## Common Tasks

### Testing the plugin locally
Link the package in a Laravel project using composer's path repository:
```json
"repositories": [
    {
        "type": "path",
        "url": "../filament-userback-plugin"
    }
]
```

### Publishing config in consumer project
```bash
php artisan vendor:publish --tag=filament-userback-config
```

## Coding Conventions

- Use `declare(strict_types=1)` in all PHP files
- Follow PSR-12 coding standards
- Use fluent interfaces (return `$this`) for setter methods
- Namespace: `CoddinWeb\FilamentUserback`
