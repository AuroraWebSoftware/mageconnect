<?php

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can list all products', function () {

    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $output->writeln('<info>foo</info>');

    //echo 'asd';
    //dump('asd');

    $mc = new \Aurorawebsoftware\Mageconnect\Mageconnect(
        url: 'https://dijital.camlicakitap.com',
        adminAccessToken: '13c5cdivjmx9my15amz7w3t1bac9vgp9',
        basePath: 'rest',
        storeCode: 'all',
        apiVersion: 'V1'
    );

    $mc->products();

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
