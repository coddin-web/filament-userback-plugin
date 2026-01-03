<?php

declare(strict_types=1);

namespace CoddinWeb\FilamentUserback;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUserbackServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-userback';

    /**
     * Configure package metadata and resources for the package manager.
     *
     * Declares the package name and registers that the package provides view templates and a configuration file.
     *
     * @param Package $package The Package instance to configure.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasConfigFile();
    }
}