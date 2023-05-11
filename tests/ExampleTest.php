<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can list all products', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $output->writeln('<info>test123</info>');

    dump(
        Mageconnect::addSearchCriteria('pageSize', 2)->products()
    );

    exit();

    //Mageconnect::getProducts();
    //Mageconnect::postProducts(PostProductDTO $dto);
    //Mageconnect::getGuestCartPaymentInformation(id);
    //Mageconnect::PostGuestCartPaymentInformation(PostGuestPaymentCartInformationDTO $dto);

    /*

    \Aurorawebsoftware\Mageconnect\Facades\Mageconnect
        ::addCriteria('pagesize', '=', '20')
        ->addCriteria('name', '=', 'asd')
        ->addCriteria([])
        ->products();
    $output->writeln($products);
    */

});
