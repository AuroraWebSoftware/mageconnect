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

it('can get products by 2 criteria using or', function () {
    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];
    $oneProduct = Mageconnect::getProduct($sku);

    $filteredProducts = Mageconnect::criteria('pageSize', 1)
        ->criteria('filterGroups.0.filters.0.field', 'name')
        ->criteria('filterGroups.0.filters.0.value', $oneProduct['name'])
        ->criteria('filterGroups.0.filters.0.conditionType', 'eq')
        ->criteria('filterGroups.0.filters.1.field', 'sku')
        ->criteria('filterGroups.0.filters.1.value', $oneProduct['sku']. 5)
        ->criteria('filterGroups.0.filters.1.conditionType', 'eq')
        ->getProducts();

    expect($filteredProducts)
        ->toBeArray()
        ->and($filteredProducts['items'][0]['name'])
        ->toEqual($oneProduct['name']);

    $filteredProducts = Mageconnect::criteria('pageSize', 1)
        ->criteria('filterGroups.0.filters.0.field', 'name')
        ->criteria('filterGroups.0.filters.0.value', $oneProduct['name']. 5)
        ->criteria('filterGroups.0.filters.0.conditionType', 'eq')
        ->criteria('filterGroups.0.filters.1.field', 'sku')
        ->criteria('filterGroups.0.filters.1.value', $oneProduct['sku'])
        ->criteria('filterGroups.0.filters.1.conditionType', 'eq')
        ->getProducts();

    expect($filteredProducts)
        ->toBeArray()
        ->and($filteredProducts['items'][0]['sku'])
        ->toEqual($oneProduct['sku']);
});

it('can get products by 2 criteria using and', function () {
    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];
    $oneProduct = Mageconnect::getProduct($sku);

    $filteredProducts = Mageconnect::criteria('pageSize', 1)
        ->criteria('filterGroups.0.filters.0.field', 'name')
        ->criteria('filterGroups.0.filters.0.value', $oneProduct['name'])
        ->criteria('filterGroups.0.filters.0.conditionType', 'eq')
        ->criteria('filterGroups.1.filters.0.field', 'sku')
        ->criteria('filterGroups.1.filters.0.value', $oneProduct['sku'])
        ->criteria('filterGroups.1.filters.0.conditionType', 'eq')
        ->getProducts();

    expect($filteredProducts)
        ->toBeArray()
        ->and($filteredProducts['items'][0]['name'])
        ->toEqual($oneProduct['name'])
        ->and($filteredProducts['items'][0]['sku'])
        ->toEqual($oneProduct['sku']);
});

it('can get zero products by a false criteria', function () {

    $products = Mageconnect::getProducts(1);
    $sku = $products['items'][0]['sku'];
    $oneProduct = Mageconnect::getProduct($sku);

    $filteredProducts = Mageconnect::criteria('pageSize', 1)
        ->criteria('filterGroups.0.filters.0.field', 'name')
        ->criteria('filterGroups.0.filters.0.value', $oneProduct['name'].rand(1, 100))
        ->criteria('filterGroups.0.filters.0.conditionType', 'eq')
        ->getProducts();

    expect($filteredProducts)
        ->toBeArray()
        ->and($filteredProducts['items'])
        ->toHaveCount(0);

});

it('can get exception from products methods by a unusual condition', function () {
    //todo akif
    expect(true)->toBeTrue();
});

it('can create, update, delete a simple product', function () {

    $sku = 'test_'.time();
    $name = "Test - $sku";

    $this->output->writeln("<info>sku : $sku </info>");

    $attributeSets = Mageconnect::getAttributeSets();

    //    expect(count($attributeSets['items']))
    //        ->toBeGreaterThan(1);

    //    $attributeSetId = $attributeSets['items'][0]['attribute_set_id'];
    $attributeSetId = 4;

    // create
    $product = [
        'product' => [
            'sku' => $sku,
            'name' => $name,
            'attribute_set_id' => $attributeSetId,
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
    $categories = Mageconnect::getCategories();

    expect($categories['children_data'])
        ->toBeArray()
        ->and($categories['children_data'])
        ->toBeIterable()
        ->and($categories['children_data'][0])
        ->toHaveKeys(['id', 'name', 'level', 'children_data']);
});

it('can get a category', function () {
    $categories = Mageconnect::getCategories();
    $categoryId = $categories['children_data'][0]['children_data'][0]['id'];

    $oneCategory = Mageconnect::getCategory($categoryId);

    expect($oneCategory)->toBeArray()
        ->and($oneCategory['id'])->toEqual($categoryId);
});

it('can get products in a category', function () {
    $categories = Mageconnect::getCategories();

    $categoryId = $categories['children_data'][0]['children_data'][0]['id'];
    $productCount = $categories['children_data'][0]['children_data'][0]['product_count'];

    $productsInCategory = Mageconnect::getCategoriesProducts($categoryId);

    expect($productsInCategory)->toBeArray()
        ->and(count($productsInCategory))->toEqual($productCount);
});
