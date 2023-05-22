<?php

namespace Aurorawebsoftware\Mageconnect\Tests;

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;
use Symfony\Component\Console\Output\ConsoleOutput;

beforeEach(function () {
    $this->output = new ConsoleOutput();
});

it('can create an empty cart ', function () {

    $cart = Mageconnect::postCart();

    expect($cart)->toBeString();
});

it('can list cart ', function () {

    $cartId = Mageconnect::postCart();

    $cart = Mageconnect::getCart($cartId);

    expect($cart)
        ->toBeArray()
        ->and([$cart['items']])
        ->toBeIterable()->and($cart)
        ->toHaveKeys(['id', 'items', 'items_count', 'is_active']);
});

it('can add an item to the cart', function () {

    $cartId = Mageconnect::postCart();

    $item = [
        'cartItem' => [
            'sku' => 'urun-sku-kodu',
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postCartItems($cartId, $item);

    expect($cartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($cartItem['sku'])
        ->toEqual($item['cartItem']['sku']);
});

it('can update an item to the cart', function () {

    $cartId = Mageconnect::postCart();

    $item = [
        'cartItem' => [
            'sku' => 'urun-sku-kodu',
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postCartItems($cartId, $item);

    $newItem = [
        'cartItem' => [
            'qty' => 5,
        ],
    ];

    $updatedCartItem = Mageconnect::putCartItems($cartId, $cartItem['item_id'], $newItem);

    expect($updatedCartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($cartItem['qty'])
        ->not->toEqual($updatedCartItem['qty']);
});

it('can delete an item to the cart', function () {
    $cartId = Mageconnect::postCart();
    $item = [
        'cartItem' => [
            'sku' => 'urun-sku-kodu',
            'qty' => 1,
        ],
    ];

    $cartItem = Mageconnect::postCartItems($cartId, $item);

    $deletedItemCart = Mageconnect::deleteCartItems($cartId, $cartItem['item_id']);
    expect($deletedItemCart)->toBeTrue();
});
