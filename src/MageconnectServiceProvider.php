<?php

namespace Aurorawebsoftware\Mageconnect;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile();
        // ->hasViews()
        // ->hasMigration('create_mageconnect_table')
        // ->hasCommand(MageconnectCommand::class)
    }

    /**
     * @throws \Exception
     */
    public function boot(): void
    {
        // return parent::boot(); //

        $this->app->bind('mageconnect', function () {
            return new MageconnectService(
                url: Config::get('mageconnect.magento_url'),
                adminAccessToken: Config::get('mageconnect.magento_admin_access_token'),
                basePath: Config::get('mageconnect.magento_base_path'),
                storeCode: (string) Config::get('mageconnect.magento_store_code'),
                apiVersion: (string) Config::get('mageconnect.magento_api_version'),
            );
        });
    }
}
