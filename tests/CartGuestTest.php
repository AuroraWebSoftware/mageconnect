<?php

namespace Aurorawebsoftware\Mageconnect\Tests;

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

    // todo Abdülaziz Exception testi

});


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
            'qty' => 1
        ],
    ];

    $updatedCartItem = Mageconnect::putCartItems($cartId, $cartItem['item_id'], $newItem);

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

    $deletedItemCart = Mageconnect::deleteCartItems($cartId, $cartItem['item_id']);
    expect($deletedItemCart)->toBeTrue();
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