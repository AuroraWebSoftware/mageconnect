<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can list a product', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getProduct('Y1390320')
    );

    exit();
});

it('can list all categories', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategories()
    );

    exit();
});

it('can list a category', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategory(21)
    );

    exit();
});

it('can list products in a category ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategoriesProducts(2)
    );

    exit();
});

it('can list create product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $product = [
        'product' => [
            'sku' => 'urun-sku-kodu',
            'name' => 'Ürün Adı',
            'attribute_set_id' => 4,
            'price' => 19.99,
            'status' => 1,
            'visibility' => 4,
            'type_id' => 'simple',
            'weight' => 0.5,
            'extension_attributes' => [
                'stock_item' => [
                    'qty' => 100,
                    'is_in_stock' => true,
                ],
            ],
        ],
    ];
    dump(
        Mageconnect::postProduct($product)
    );

    exit();
});

it('can list update product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $product = [
        'product' => [
            'name' => 'Test Ürünü Mageconnect 2 ',
            'attribute_set_id' => 4,
            'price' => 39.99,
            'extension_attributes' => [
                'stock_item' => [
                    'qty' => 200,
                    'is_in_stock' => true,
                ],
            ],
        ],
    ];
    dump(
        Mageconnect::putProduct('urun-sku-kodu', $product)
    );

    exit();
});

it('can list delete product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::deleteProduct('urun-sku-kodu')
    );

    exit();
});
