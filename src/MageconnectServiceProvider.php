<?php

namespace Aurorawebsoftware\Mageconnect;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Aurorawebsoftware\Mageconnect\Commands\MageconnectCommand;

class MageconnectServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mageconnect')
            ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_mageconnect_table')
            // ->hasCommand(MageconnectCommand::class)
        ;
    }
}
