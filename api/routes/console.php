<?php

use App\Http\Controllers\GazetteFetchController;
use Goutte\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('fetch', function () {
    $client = app()->make(Client::class);
    $fetcher = app()->make(GazetteFetchController::class);
    foreach(range(1, 11675) as $page) {
        $ads = $fetcher->getNews($page, $client);
        sleep(5);
        echo $page;
    }
    
})->purpose('fetch adds');
