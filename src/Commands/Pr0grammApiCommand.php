<?php

namespace Tschucki\Pr0grammApi\Commands;

use Illuminate\Console\Command;

class Pr0grammApiCommand extends Command
{
    public $signature = 'laravel-pr0gramm-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
