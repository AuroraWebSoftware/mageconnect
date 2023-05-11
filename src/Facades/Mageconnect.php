<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Aurorawebsoftware\Mageconnect\MageconnectService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\MageconnectService
 *
 * @method static MageconnectService products()
 * @method static MageconnectService addSearchCriteria(string $key, string|int|float $value)
 */
class Mageconnect extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // return \Aurorawebsoftware\Mageconnect\MageconnectService::class;
        return 'mageconnect';
    }
}
