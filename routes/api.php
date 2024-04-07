<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Flujo basico

//Envia mensajes
Route::get('/envia',[ChatbotController::class,'envia']);
//Verifica el webhook
Route::get('/webhook',[ChatbotController::class,'verifyWebhook']);
//Procesa los mensajes enviados por el chatbot y usuario al chatbot
Route::post('/webhook',[ChatbotController::class,'processWebhook']); 