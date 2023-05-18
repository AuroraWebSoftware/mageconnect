# Mageconnect - Magento Api Connector Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aurorawebsoftware/mageconnect.svg?style=flat-square)](https://packagist.org/packages/aurorawebsoftware/mageconnect)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/aurorawebsoftware/mageconnect/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/aurorawebsoftware/mageconnect/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aurorawebsoftware/mageconnect/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aurorawebsoftware/mageconnect/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/aurorawebsoftware/mageconnect.svg?style=flat-square)](https://packagist.org/packages/aurorawebsoftware/mageconnect)


Mageconnect is a powerful Laravel package designed to seamlessly integrate Magento APIs into your Laravel applications. 
With Mageconnect, you can effortlessly communicate with Magento's REST APIs and access various Magento functionalities, 
including retrieving product information, managing customer data, handling orders, and much more.

## Requirements
- Php 8.2 or Higher
- Laravel 10+
- Magento 2.x


## Installation

You can install the package via composer:

```bash
composer require aurorawebsoftware/mageconnect
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mageconnect-config"
```

This is the contents of the published config file:

```php
return [
    'magento_url' => env('MAGENTO_URL'),
    'magento_admin_access_token' => env('MAGENTO_URL'),
    'magento_customer_access_token' => env('MAGENTO_CUSTOMER_ACCESS_TOKEN'),

    'magento_base_path' => env('MAGENTO_BASE_PATH', 'rest'),
    'magento_store_code' => env('MAGENTO_STORE_CODE', 'all'),
    'magento_api_version' => env('MAGENTO_API_VERSON', 'V1'),
];
```

Laravel **.env** File
```dotenv
MAGENTO_URL="https://magento.test"
MAGENTO_ADMIN_ACCESS_TOKEN="token"

MAGENTO_CUSTOMER_ACCESS_TOKEN="token"

# optional
MAGENTO_BASE_PATH="rest"
MAGENTO_STORE_CODE="all"
MAGENTO_API_VERSON="V1"

```

## Usage

// todo 

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](README-CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [AuroraWebSoftwareTeam](https://github.com/AuroraWebSoftware)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
