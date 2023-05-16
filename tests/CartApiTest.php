<?php

namespace Aurorawebsoftware\Mageconnect\Tests;


use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;

it('can create an empty cart ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::postCart()
    );
    exit();
});

it('can list cart ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCart('fOp50ntvJpTuoW1CGMy5JyoguG8eI2Do')
    );
    exit();
});

it('can add an item to the cart', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $cartId = "fOp50ntvJpTuoW1CGMy5JyoguG8eI2Do";
    $item = [
        "cartItem" => [
            "quote_id" => "fOp50ntvJpTuoW1CGMy5JyoguG8eI2Do",
            "sku" => "urun-sku-kodu",
            "qty" => 12
        ],
    ];

    dump(
        Mageconnect::postCartItems($cartId,$item)
    );
    exit();
});

it('can update an item to the cart', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $cartId = "fOp50ntvJpTuoW1CGMy5JyoguG8eI2Do";
    $itemId = 519586;

    $item = [
        "cartItem" => [
            "qty" => 5
        ],
    ];

    dump(
        Mageconnect::putCartItems($cartId,$itemId,$item)

    );
    exit();
});

it('can delete an item to the cart', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $cartId = "fOp50ntvJpTuoW1CGMy5JyoguG8eI2Do";
    $itemId = 519586;

    dump(
        Mageconnect::deleteCartItems($cartId,$itemId)

    );
    exit();
});



