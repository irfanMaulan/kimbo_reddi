<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('whatsapp/callback', function (Request $request) {
    Log::info(json_encode(array_merge(['method' => 'POST'], $request->all())));

    $client = new \GuzzleHttp\Client([
        'timeout' => 30,
    ]);
    $response = $client->request('POST', env('BASE_API_URL').'/whatsapp/callback', ['json' => $request->all()]);
    $result = $response->getBody()->__toString();
    Log::info($result);

    return response($result);
});

Route::get('whatsapp/callback', function (Request $request) {
    Log::info(json_encode(array_merge(['method' => 'GET'], $request->all())));

    $client = new \GuzzleHttp\Client([
        'timeout' => 30,
    ]);
    $response = $client->request('GET', env('BASE_API_URL').'/whatsapp/callback', ['json' => $request->all()]);
    $result = $response->getBody()->__toString();
    Log::info($result);

    return response($result);
});
