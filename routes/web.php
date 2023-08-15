<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/redshift', function () {

    $serviceDiscovery = config("app.service_discovery");
    if (empty($serviceDiscovery["hbv2-redshift"])) return null;

    $redshiftEndpoint = $serviceDiscovery["hbv2-redshift"];
    $apiCallURL = "{$redshiftEndpoint}/api/redshift/data";
    $articles = Http::get($apiCallURL)->collect();

    return view('redshift', compact("articles"));
});

Route::get('/', function () {
    return view('welcome');
});
//Route::any('/{any}', [Hbv2Controller::class, 'processRequest'])->where('any', '.*');

