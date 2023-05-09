<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel;

use RonildoSousa\DevtoForLaravel\Commands\DevtoForLaravelCommand;
use Spatie\LaravelPackageTools\{Package, PackageServiceProvider};

class DevtoForLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('devto-for-laravel')
            ->hasConfigFile(['devto-for-laravel', 'articles_sample', 'single_article_sample'])
            ->hasViews()
            ->hasMigration('create_devto-for-laravel_table')
            ->hasCommand(DevtoForLaravelCommand::class);
    }
}
