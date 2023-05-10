<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\Mageconnect
 */
class Mageconnect extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aurorawebsoftware\Mageconnect\Mageconnect::class;
    }
}
