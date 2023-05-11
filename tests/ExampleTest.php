<?php

use Aurorawebsoftware\Mageconnect\Facades\Mageconnect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

it('can test', function () {
    expect(true)->toBeTrue();
});



it('can list all products', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $output->writeln('<info>test123</info>');



    dump(
        Mageconnect::addSearchCriteria('pageSize', 2)->products()
    );

    die();

    //Mageconnect::products();

    //$mc->products();

    /*

    User::where('id', '=', '14');
    User::where([['id', '=', 14], ['name', '=', 'ahmet']]);

    \Aurorawebsoftware\Mageconnect\Facades\Mageconnect
        ::addCriteria('pagesize', '=', '20')
        ->addCriteria('name', '=', 'asd')
        ->addCriteria([])
        ->products();


    $output->writeln($products);
    */

});
