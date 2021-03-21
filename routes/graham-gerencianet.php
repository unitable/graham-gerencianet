<?php

use Illuminate\Support\Facades\Route;
use Unitable\GrahamGerencianet\Http\Controllers;

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

Route::group(['as' => 'graham-gerencianet.', 'prefix' => 'graham-gerencianet/'], function() {

    Route::post('postback', [Controllers\WebhookController::class, 'handleWebhook'])->name('webhook');

});
