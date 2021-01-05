<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
$router->group(['prefix'=>'apps'],function() use ($router){
    $router->post('/register',[ApiController::class, 'register']);
    $router->post('/login',[ApiController::class, 'login']);
    $router->post('/home',[ApiController::class, 'home']);
    $router->get('/tips',[ApiController::class, 'tips']);
    $router->get('/produk',[ApiController::class, 'produk']);
    $router->get('/tentang',[ApiController::class, 'tentang']);
    $router->post('/konsultasi',[ApiController::class, 'konsultasi']);
    $router->post('/complaint',[ApiController::class, 'allcomplaint']);
    $router->post('/addhistory',[ApiController::class, 'addhistory']);
    $router->post('/history',[ApiController::class, 'history']);
});
