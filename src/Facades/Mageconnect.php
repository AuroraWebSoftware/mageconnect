<?php

namespace Aurorawebsoftware\Mageconnect\Facades;

use Aurorawebsoftware\Mageconnect\MageconnectService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aurorawebsoftware\Mageconnect\MageconnectService
 *
 * @method static array getProducts(int $pageSize = 20) @throws HttpResponseStatusException
 * @method static array getProduct(string $sku) @throws HttpResponseStatusException
 * @method static MageconnectService getCategories() @throws HttpResponseStatusException
 * @method static MageconnectService getCategory(int $categoryId) @throws HttpResponseStatusException
 * @method static MageconnectService getCategoriesProducts(int $categoryId) @throws HttpResponseStatusException
 * @method static MageconnectService postProduct(array $data) @throws HttpResponseStatusException
 * @method static MageconnectService deleteProduct(string $sku) @throws HttpResponseStatusException
 * @method static array putProduct(string $sku, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService criteria(string $key, string|int|float $value)
 * @method MageconnectService criteria(string $key, string|int|float $value)
 * @method static string postGuestCart() @throws HttpResponseStatusException
 * @method static array getGuestCart(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService postGuestCartItems(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService putCartItems(string $cartId, int $itemId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService deleteCartItems(string $cartId, int $itemId) @throws HttpResponseStatusException
 * @method static MageconnectService customerToken(string $token)
 * @method static MageconnectService loginCustomer(string $username, string $password)
 * @method static array cartMineTotals() @throws HttpResponseStatusException
 * @method array cartMineTotals() @throws HttpResponseStatusException
 */
class Mageconnect extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // return \Aurorawebsoftware\Mageconnect\MageconnectService::class;
        return 'mageconnect';
    }
}
