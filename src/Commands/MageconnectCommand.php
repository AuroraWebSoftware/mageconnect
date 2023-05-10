<?php

namespace Aurorawebsoftware\Mageconnect\Commands;

use Illuminate\Console\Command;

class MageconnectCommand extends Command
{
    public $signature = 'mageconnect';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
