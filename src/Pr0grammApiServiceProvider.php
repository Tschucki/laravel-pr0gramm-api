<?php

namespace Tschucki\Pr0grammApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tschucki\Pr0grammApi\Commands\Pr0grammApiCommand;

class Pr0grammApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-pr0gramm-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-pr0gramm-api_table')
            ->hasCommand(Pr0grammApiCommand::class);
    }
}
