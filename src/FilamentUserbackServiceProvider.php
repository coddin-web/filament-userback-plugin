<?php

declare(strict_types=1);

namespace CoddinWeb\FilamentUserback;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUserbackServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-userback';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasConfigFile();
    }
}
