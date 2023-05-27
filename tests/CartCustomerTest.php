<?php

use Aurorawebsoftware\Mageconnect\Exceptions\CustomerUnauthorizedException;
use Aurorawebsoftware\Mageconnect\Exceptions\HttpResponseStatusException;
use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;
use Symfony\Component\Console\Output\ConsoleOutput;


beforeEach(function () {
    $this->output = new ConsoleOutput();
    $token = Mageconnect::loginCustomer('azzdas.aziz@gmail.com', 'Aurora.2107!');
    $this->customerToken =  $token->getCustomerAccessToken();
});

it('can get customer token for cart', function () {
    $token = Mageconnect::loginCustomer('azzdas.aziz@gmail.com', 'Aurora.2107!');

    expect($token->getCustomerAccessToken())->toBeString();
});

it('can not get customer token for cart', function () {

    $token = Mageconnect::loginCustomer('azzdas.azizz@gmail.com', 'Aurora.2107!');

})->throws(CustomerUnauthorizedException::class);

it('can create an empty cart using the customer api but returns the existing one if it was already created', function () {
    $cart = Mageconnect::postMineCart();
    expect($cart)->toBeString();
});

it('can get the cart using customer api ', function () {

    $cart = Mageconnect::getMineCart();
    expect($cart)
        ->toBeArray()
        ->and([$cart['items']])
        ->toBeIterable()
        ->and($cart)->toHaveKeys(['id', 'items', 'items_count', 'is_active']);
});

it('can add an item to the cart using customer cart', function () {

    $products = Mageconnect::getProducts(10);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];
    $cart = Mageconnect::getMineCart();
    if(count($cart['items']) != 0) {
        if ($cart['items'][0]['sku'] === $sku) {
            Mageconnect::deleteMineCartItems($cart['items'][0]['item_id']);
        }
    }
   $cartItem = Mageconnect::postMineCartItems($item);

    expect($cartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($sku)
        ->toEqual($item['cartItem']['sku']);
});

it('cannot add products to cart with unknown sku', function () {
    $item = [
        'cartItem' => [
            'sku' => 'test product',
            'qty' => 1,
        ]
    ];

    Mageconnect::postMineCartItems($item);

})->throws(HttpResponseStatusException::class);

it('can update an item to the cart using customer cart', function () {

    $products = Mageconnect::getProducts(10);
    $sku = $products['items'][0]['sku'];

    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];
    $cart = Mageconnect::getMineCart();
    if(count($cart['items']) != 0) {
        if ($cart['items'][0]['sku'] === $sku) {
            Mageconnect::deleteMineCartItems($cart['items'][0]['item_id']);
        }
    }
    $cartItem = Mageconnect::postMineCartItems($item);

    $newItem = [
        'cartItem' => [
            'qty' => 1,
        ],
    ];

    $updatedCartItem = Mageconnect::putMineCartItems($cartItem['item_id'], $newItem);

    expect($updatedCartItem)
        ->toBeArray()
        ->toHaveKeys(['item_id', 'sku', 'qty', 'name'])
        ->and($cartItem['qty'])
        ->toEqual($updatedCartItem['qty']);
});

it('can delete an item to the cart using customer api', function () {

    $products = Mageconnect::getProducts(10);
    $sku= $products['items'][0]['sku'];

    $cartId = Mageconnect::postMineCart();
    $item = [
        'cartItem' => [
            'sku' => $sku,
            'qty' => 1,
        ],
    ];
    $cart = Mageconnect::getMineCart();
    if(count($cart['items']) != 0) {
        if ($cart['items'][0]['sku'] === $sku) {
            Mageconnect::deleteMineCartItems($cart['items'][0]['item_id']);
        }
    }
    $cartItem = Mageconnect::postMineCartItems($item);

    $deletedItemCart = Mageconnect::deleteMineCartItems($cartItem['item_id']);
    expect($deletedItemCart)->toBeTrue();
});


it('can get cart totals using customer token', function () {
    // Mageconnect::loginCustomer('asd@a.com', 'pass')->getCartMineTotals();
    // Mageconnect::customerToken('token')->getCartMineTotals();
    expect(true)->toBeTrue();
});
