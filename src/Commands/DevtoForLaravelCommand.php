<?php declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Commands;

use Illuminate\Console\Command;

class DevtoForLaravelCommand extends Command
{
    public $signature = 'devto-for-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
