<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can list all products', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $output->writeln('<info>test123</info>');

    dump(
        Mageconnect::addSearchCriteria('pageSize', 2)->addSearchCriteria('filterGroups.0.filters.0.field', 'entity_id')
            ->addSearchCriteria('filterGroups.0.filters.0.value', 21)
            ->addSearchCriteria('filterGroups.0.filters.0.conditionType', 'eq')
            ->getProducts()
    );

    exit();
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

it('can list get all orders ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::addSearchCriteria('searchCriteria', 'all')->getOrders()
    );

    exit();
});

it('can list get a order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::getOrder(4)
    );

    exit();
});

it('can list delete order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::deleteOrder(4)
    );

    exit();
});

it('can list cancel order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::cancelOrder(4)
    );

    exit();
});


it('can list hold order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::holdOrder(5)
    );

    exit();
});

it('can list unhold order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::unHoldOrder(5)
    );

    exit();
});

it('can list refund order ', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    dump(
        Mageconnect::refundOrder(10, [
            "items" => [
                [
                    "order_item_id" => 13,
                    "qty" => 1
                ]
            ],
            "notify" => true,
            "arguments" => [
                "shipping_amount" => null,
                "adjustment_positive" => 1,
                "adjustment_negative" => 1,
                "extension_attributes" => [
                    "return_to_stock_items" => [
                        1
                    ]
                ]
            ]
        ])
    );

    exit();
});

it('can list update order ', function () {

    #todo tamamlanmadı
    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $data = [
        "entity" => [
            "firstname" => "string",
            "lastname" => "string",

        ]
    ];
    dump(
        Mageconnect::putOrders(10, $data)
    );
});
