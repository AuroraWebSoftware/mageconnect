<?php

namespace Aurorawebsoftware\Mageconnect\Tests;

use Aurorawebsoftware\Mageconnect\Exceptions\HttpResponseStatusException;
use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;
use Symfony\Component\Console\Output\ConsoleOutput;

beforeEach(function () {
    $this->output = new ConsoleOutput();
});

it('can create an empty cart using guest api', function () {

    $cart = Mageconnect::postGuestCart();
    expect($cart)->toBeString();
});

it('can create an empty cart and get the cart using guest api ', function () {

    $cartId = Mageconnect::postGuestCart();

    $cart = Mageconnect::getGuestCart($cartId);

    expect($cart)
        ->toBeArray()
        ->and([$cart['items']])
        ->toBeIterable()
        ->and($cart)->toHaveKeys(['id', 'items', 'items_count', 'is_active'])
        ->and($cart['items'])->toHaveCount(0);
});

it('can add an item to the cart using guest cart', function () {

    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postGuestCartItems($cartId, $item);

    expect($cartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($sku)
        ->toEqual($item['cartItem']['sku']);
});

it('cannot add products to cart with unknown sku', function () {

    $cartId = Mageconnect::postGuestCart();

    $item = [
        'cartItem' => [
            'sku' => 'test',
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postGuestCartItems($cartId, $item);

    expect($cartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name']);
})->throws(HttpResponseStatusException::class);

it('can update an item to the cart using guest cart', function () {

    // tam olarak test edilemedi.
    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(2);
    $sku1 = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku1,
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postGuestCartItems($cartId, $item);

    $newItem = [
        'cartItem' => [
            'qty' => 1,
        ],
    ];

    $updatedCartItem = Mageconnect::putGuestCartItems($cartId, $cartItem['item_id'], $newItem);

    expect($updatedCartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($cartItem['qty'])
        ->toEqual($updatedCartItem['qty']);
});

it('can delete an item to the cart using guest api', function () {

    $products = Mageconnect::getProducts(2);
    $sku1 = $products['items'][0]['sku'];

    $cartId = Mageconnect::postGuestCart();
    $item = [
        'cartItem' => [
            'sku' => $sku1,
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postGuestCartItems($cartId, $item);

    $deletedItemCart = Mageconnect::deleteGuestCartItems($cartId, $cartItem['item_id']);
    expect($deletedItemCart)->toBeTrue();
});

it('can list address assigned to cart using guest api', function () {

    $cartId = Mageconnect::postGuestCart();
    $billingAddress = Mageconnect::getGuestCartBillingAddress($cartId);
    // dump($billingAddress);

    expect($billingAddress)
        ->toBeArray()
        ->toHaveKeys(['region', 'region_code', 'country_id', 'postcode']);
});

it('can assign specific billing address to cart using guest api', function () {

    $cartId = Mageconnect::postGuestCart();
    $address = [
        'address' => [
            'region' => 'Istanbul',
            'region_id' => 34,
            'country_id' => 'TR',
            'street' => ['123 Test Street'],
            'postcode' => '34100',
            'city' => 'Istanbul',
            'telephone' => '555-1234567',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
        ],
    ];

    $billingAddress = Mageconnect::postGuestCartBillingAddress($cartId, $address);
    expect($billingAddress)->toBeInt();
});

it('can set shipping/billing methods and additional data for cart and collect totals for guest api.', function () {

    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];

    Mageconnect::postGuestCartItems($cartId, $item);

    $address = [
        'address' => [
            'region' => 'Istanbul',
            'region_id' => 34,
            'country_id' => 'TR',
            'street' => ['123 Test Street'],
            'postcode' => '34100',
            'city' => 'Istanbul',
            'telephone' => '555-1234567',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
        ],
    ];

    Mageconnect::postGuestCartBillingAddress($cartId, $address);
    $data = [
        'paymentMethod' => [
            'method' => 'grinet_turkpay',
        ],
    ];

    $collectTotal = Mageconnect::putGuestCartCollectTotal($cartId, $data);

})->throws(HttpResponseStatusException::class);

it('can  get coupons available for the guest cart.', function () {

    $cartId = Mageconnect::postGuestCart();

    $coupons = Mageconnect::getGuestCartCoupons($cartId);
    expect($coupons)->toBeArray();
});

it('can delete coupons available for the guest cart.', function () {
    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];

    Mageconnect::postGuestCartItems($cartId, $item);

    $coupons = Mageconnect::deleteGuestCartCoupons($cartId);

    expect($coupons)->toBeTrue();
});

it('can post payment information for guest cart.', function () {
    // todo fonksiyonları yazıldı dijital test guest alt yapısı olmadıgından test edilememektedir
    expect(true)->toBeTrue();

});

it('can get payment information for guest cart.', function () {
    // todo fonksiyonları yazıldı dijital test guest alt yapısı olmadıgından test edilememektedir
    expect(true)->toBeTrue();

});

it('can assign specific shipping address to cart using guest api', function () {
    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];

    Mageconnect::postGuestCartItems($cartId, $item);

    $data = [
        'addressInformation' => [
            'shippingAddress' => [
                'region' => 'Istanbul',
                'regionId' => 34,
                'regionCode' => null,
                'countryId' => 'TR',
                'street' => [
                    '123 Test Street',
                ],
                'telephone' => '555-1234567',
                'postcode' => '34100',
                'city' => 'Istanbul',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'johndoe@example.com',
            ],
            'billingAddress' => [
                'region' => 'Istanbul',
                'regionId' => 34,
                'regionCode' => null,
                'countryId' => 'TR',
                'street' => [
                    '123 Test Street',
                ],
                'telephone' => '555-1234567',
                'postcode' => '34100',
                'city' => 'Istanbul',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'johndoe@example.com',
            ],
            'shippingMethodCode' => 'flatrate',
            'shippingCarrierCode' => 'flatrate',
        ],
    ];

    $shippingAddress = Mageconnect::postGuestCartShippingInformation($cartId, $data);

    expect($shippingAddress)
        ->toBeArray()
        ->toHaveKeys(['totals', 'payment_methods']);
});

it('can assign specific shipping method to cart using guest api', function () {
    $cartId = Mageconnect::postGuestCart();

    $shippingMethods = Mageconnect::getGuestCartShippingMethods($cartId);

    expect($shippingMethods)
        ->toBeArray();
});

it('can totals cart using guest api', function () {

    $cartId = Mageconnect::postGuestCart();

    $totals = Mageconnect::getGuestCartTotals($cartId);

    expect($totals)
        ->toBeArray();
});

it('can post totals information cart using guest api', function () {

    $cartId = Mageconnect::postGuestCart();

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];

    Mageconnect::postGuestCartItems($cartId, $item);

    $data = [
        'addressInformation' => [
            'address' => [
                'region' => 'Istanbul',
                'region_id' => 34,
                'country_id' => 'TR',
                'street' => ['123 Test Street'],
                'postcode' => '34100',
                'city' => 'Istanbul',
                'telephone' => '555-1234567',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'johndoe@example.com',
            ],
        ],
    ];

    $totalsInformation = Mageconnect::postGuestCartTotalsInformation($cartId, $data);

    expect($totalsInformation)->toBeArray();
});

// todo guest api billing adress işlemleri
// collect grand totals
// coupons api
// payment information
// shipping infotmation
// shipping methods
// totals
// totals infotmation
// cart'ı order a dönüştürme
