<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Predis\Client;

Route::get('/', function () {
    return $test = Redis::ping();//view('welcome');
});



// Route::get('/', function () {
//     $redis = new Client([
//         'scheme' => 'tcp',
//         'host'   => '127.0.0.1',
//         'port'   => 6379,
//     ]);

//     $redis->set('test', 'اهلا Redis!');
//     return $redis->get('test');
// });
