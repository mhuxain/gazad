<?php

namespace App\Console\Commands;

use App\Http\Controllers\GazetteFetchController;
use Goutte\Client;
use Illuminate\Console\Command;

class GazadFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gazad:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch from gazette';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = app()->make(Client::class);
    $fetcher = app()->make(GazetteFetchController::class);
    foreach(range(92, 11675) as $page) {
        $ads = $fetcher->getNews($page, $client);
        $this->info("page $page done");
        sleep(2);
    }
        return 0;
    }
}
