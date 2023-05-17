<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;
use Symfony\Component\Console\Output\ConsoleOutput;

beforeEach(function () {
    $this->output = new ConsoleOutput();
});

it('can get products', function () {

    $this->output->writeln('<info>can get products</info>');

    $products = Mageconnect::getProducts(10);

    expect($products)
        ->toBeArray()
        ->and($products['items'])
        ->toBeIterable()
        ->and($products['items'])
        ->toHaveCount(10)
        ->and($products['items'][0])
        ->toHaveKeys(['id', 'sku', 'name', 'price', 'status']);
});

it('can get one products by sku', function () {

    $this->output->writeln('<info>can get one products by sku</info>');

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];
    $oneProduct = Mageconnect::getProduct($sku);

    expect($oneProduct)->toBeArray()
        ->and($oneProduct['sku'])->toEqual($sku);
});

it('can get products by one criteria', function () {

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];
    $oneProduct = Mageconnect::getProduct($sku);

    $filteredProducts = Mageconnect::criteria('pageSize', 1)
        ->criteria('filterGroups.0.filters.0.field', 'name')
        ->criteria('filterGroups.0.filters.0.value', $oneProduct['name'])
        ->criteria('filterGroups.0.filters.0.conditionType', 'eq')
        ->getProducts();

    expect($filteredProducts)
        ->toBeArray()
        ->and($filteredProducts['items'][0]['name'])
        ->toEqual($oneProduct['name']);
});

it('can get products by 2 criteria', function () {

});

it('can get zero products by a false criteria', function () {

});

it('can get exception from products methods by a unusual condition', function () {

});

it('can create, update, delete a simple product', function () {

    $sku = 'test_'.time();
    $name = "Test - $sku";

    $this->output->writeln("<info>sku : $sku </info>");

    // todo attribute_set_id api'den geitirilmeli

    // create
    $product = [
        'product' => [
            'sku' => $sku,
            'name' => $name,
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
    $postedProduct = Mageconnect::postProduct($product);

    expect($postedProduct)
        ->toBeArray()
        ->and($postedProduct['sku'])->toEqual($sku);

    // update
    $name = "Test Updated - $sku";

    $product = [
        'product' => ['name' => $name],
    ];

    $putProduct = Mageconnect::putProduct($sku, $product);

    expect($putProduct)
        ->toBeArray()
        ->and($putProduct['sku'])->toEqual($sku)
        ->and($putProduct['name'])->toEqual($name);

    //delete
    $deletedProduct = Mageconnect::deleteProduct($sku);

    expect($deletedProduct)->toBeTrue();
});

it('can get Exception when deleting non-existing product', function () {

    $sku = 'nonexisting_sku'.time();
    $deletedProduct = Mageconnect::deleteProduct($sku);

})->expectException(Exception::class);

it('can get all categories', function () {

    dump(
        Mageconnect::getCategories()
    );

    exit();
});

it('can get a category', function () {

    dump(
        Mageconnect::getCategory(21)
    );

    exit();
});

it('can get products in a category ', function () {

    dump(
        Mageconnect::getCategoriesProducts(2)
    );

});
