<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Aurorawebsoftware\Mageconnect\MageconnectService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\MageconnectService
 *
 * @method static array getProducts()
 * @method static array getOrders()
 * @method static array deleteOrder(int $entityId)
 * @method static array cancelOrder(int $entityId)
 * @method static array holdOrder(int $entityId)
 * @method static array unHoldOrder(int $entityId)
 * @method static array refundOrder(int $entityId , array $data)
 * @method static array putOrders(int $entityId , array $data)
 * @method static MageconnectService getOrder(int $entityId)
 * @method static MageconnectService getProduct(string|int $sku)
 * @method static MageconnectService getCategories()
 * @method static MageconnectService getCategory(int $categoryId)
 * @method static MageconnectService getCategoriesProducts(int $categoryId)
 * @method static MageconnectService postProduct(array $data)
 * @method static MageconnectService deleteProduct(string $sku)
 * @method static MageconnectService putProduct(string $sku , array $data)
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
