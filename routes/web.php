<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/webhook', [\App\Http\Controllers\FacebookWebhookController::class, 'handleWebhook']);
Route::get('/logs', function () {
    $path = storage_path('logs/laravel.log');

    if (!File::exists($path)) {
        abort(404, 'Log file not found.');
    }

    $content = File::get($path);
    return \Illuminate\Support\Facades\Response::make(nl2br($content), 200)
        ->header('Content-Type', 'text/html');
});
