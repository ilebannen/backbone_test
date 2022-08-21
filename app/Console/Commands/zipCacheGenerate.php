<?php

namespace App\Console\Commands;

use App\Services\ZipJsonGenerator;
use Illuminate\Console\Command;

class zipCacheGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:generate-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for cache generation on redis';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ZipJsonGenerator::generate();
        return 0;
    }
}
