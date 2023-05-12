<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can list all products', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $output->writeln('<info>test123</info>');

    dump(
        Mageconnect::addSearchCriteria('pageSize', 2)->addSearchCriteria('filterGroups.0.filters.0.field' , 'entity_id')
                ->addSearchCriteria('filterGroups.0.filters.0.value' , 21)
                ->addSearchCriteria('filterGroups.0.filters.0.conditionType' , 'eq')
            ->getProducts()
    );

    die();
});

it('can list a product', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getProduct("Y1390320")
    );

    die();
});


it('can list all categories', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategories()
    );

    die();
});

it('can list a category', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategory(21)
    );

    die();
});


it('can list products in a category ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    dump(
        Mageconnect::getCategoriesProducts(2)
    );

    die();
});

it('can list create product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $product = [
        "product" => [
            "sku" => "urun-sku-kodu",
            "name" => "Ürün Adı",
            "attribute_set_id" => 4,
            "price" => 19.99,
            "status" => 1,
            "visibility" => 4,
            "type_id" => "simple",
            "weight" => 0.5,
            "extension_attributes" => [
                "stock_item" => [
                    "qty" => 100,
                    "is_in_stock" => true
                ]
            ]
        ]
    ];
    dump(
        Mageconnect::postProduct($product)
    );

    die();
});


it('can list update product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $product = [
        "product" => [
            "name" => "Test Ürünü Mageconnect 2 ",
            "attribute_set_id" => 4,
            "price" => 39.99,
            "extension_attributes" => [
                "stock_item" => [
                    "qty" => 200,
                    "is_in_stock" => true
                ]
            ]
        ]
    ];
    dump(
        Mageconnect::putProduct("urun-sku-kodu", $product)
    );

    die();
});


it('can list delete product ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::deleteProduct("urun-sku-kodu")
    );

    die();
});
