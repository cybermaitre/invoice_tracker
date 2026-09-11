<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\InvoiceController;

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout',[AuthController::class, 'logout']);
    Route::apiResource('clients', ClientController::class);
    Route::get('/invoices/overdue', [InvoiceController::class, 'overdue']);

    Route::apiResource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'send']);
    Route::post('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid']);
    //Route::get('/clients/{client:client_name}', [ClientController::class, 'show']);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf']);


    Route::get('/user', function (Request $request) {
    return $request->user();
    });
});


