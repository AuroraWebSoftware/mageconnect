<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Aurorawebsoftware\Mageconnect\MageconnectService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\MageconnectService
 *
 * @method static array getProducts(int $pageSize = 20)
 * @method static array getProduct(string $sku)
 * @method static MageconnectService getCategories()
 * @method static MageconnectService getCategory(int $categoryId)
 * @method static MageconnectService getCategoriesProducts(int $categoryId)
 * @method static MageconnectService postProduct(array $data)
 * @method static MageconnectService deleteProduct(string $sku)
 * @method static array putProduct(string $sku, array $data)
 * @method static MageconnectService criteria(string $key, string|int|float $value)
 * @method MageconnectService criteria(string $key, string|int|float $value)
 * @method static MageconnectService postCart()
 * @method static MageconnectService getCart(string $cartId)
 * @method static MageconnectService postCartItems(string $cartId , array $data)
 * @method static MageconnectService putCartItems(string $cartId ,int $itemId, array $data)
 * @method static MageconnectService deleteCartItems(string $cartId ,int $itemId)
 */
class Mageconnect extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // return \Aurorawebsoftware\Mageconnect\MageconnectService::class;
        return 'mageconnect';
    }
}
