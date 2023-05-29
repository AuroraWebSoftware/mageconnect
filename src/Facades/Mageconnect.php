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
 * @method static MageconnectService putGuestCartItems(string $cartId, int $itemId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService deleteGuestCartItems(string $cartId, int $itemId) @throws HttpResponseStatusException
 * @method static MageconnectService getGuestCartBillingAddress(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService postGuestCartBillingAddress(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService putGuestCartCollectTotal(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService getGuestCartCoupons(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService deleteGuestCartCoupons(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService postGuestCartPaymentInformation(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService getGuestCartPaymentInformation(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService postGuestCartShippingInformation(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService getGuestCartShippingMethods(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService getGuestCartTotals(string $cartId) @throws HttpResponseStatusException
 * @method static MageconnectService postGuestCartTotalsInformation(string $cartId, array $data) @throws HttpResponseStatusException
 * @method static string postMineCart() @throws HttpResponseStatusException
 * @method static array getMineCart() @throws HttpResponseStatusException
 * @method static MageconnectService getMineCartItems() @throws HttpResponseStatusException
 * @method static MageconnectService postMineCartItems(array $data) @throws HttpResponseStatusException
 * @method static MageconnectService putMineCartItems(int $itemId, array $data) @throws HttpResponseStatusException
 * @method static MageconnectService deleteMineCartItems(int $itemId) @throws HttpResponseStatusException
 * @method static MageconnectService customerToken(string $token)
 * @method static MageconnectService loginCustomer(string $username, string $password)
 * @method static MageconnectService setCustomerAccessToken(string $token)
 * @method static MageconnectService getCustomerAccessToken()
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
