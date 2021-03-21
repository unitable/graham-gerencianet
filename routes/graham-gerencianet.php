<?php

use Illuminate\Support\Facades\Route;
use Unitable\GrahamGerencianet\Http\Controllers;
use Unitable\GrahamGerencianet\Methods\Pix\Http\Controllers as Pix;

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

Route::group(['as' => 'graham-gerencianet.', 'prefix' => 'graham-gerencianet'], function() {

    Route::post('/webhook', [Controllers\WebhookController::class, 'handleWebhook'])->name('webhook');

    Route::post('/pix/webhook', [Pix\WebhookController::class, 'handleWebhook'])->name('pix.webhook');

});
