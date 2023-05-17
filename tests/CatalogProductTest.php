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


it('can get products by criteria', function () {

    dump(
        Mageconnect::addSearchCriteria('pageSize', 2)->addSearchCriteria('filterGroups.0.filters.0.field', 'entity_id')
            ->addSearchCriteria('filterGroups.0.filters.0.value', 21)
            ->addSearchCriteria('filterGroups.0.filters.0.conditionType', 'eq')
            ->getProducts()
    );
});


