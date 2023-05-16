<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Aurorawebsoftware\Mageconnect\MageconnectService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\MageconnectService
 *
 * @method static MageconnectService getProducts()
 * @method static MageconnectService getProduct(string|int $sku)
 * @method static MageconnectService getCategories()
 * @method static MageconnectService getCategory(int $categoryId)
 * @method static MageconnectService getCategoriesProducts(int $categoryId)
 * @method static MageconnectService postProduct(array $data)
 * @method static MageconnectService deleteProduct(string $sku)
 * @method static MageconnectService putProduct(string $sku , array $data)
 * @method static MageconnectService postCart()
 * @method static MageconnectService getCart(string $cartId)
 * @method static MageconnectService postCartItems(string $cartId , array $data)
 * @method static MageconnectService putCartItems(string $cartId ,int $itemId, array $data)
 * @method static MageconnectService deleteCartItems(string $cartId ,int $itemId)
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
