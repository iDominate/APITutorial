<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;
use App\Models\Category;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api', 'checkPassword']], function(){

    //Password is mandatory for a secure API
    Route::get('/get-persons',  [PersonController::class,'index']);

    Route::get('/all-persons', [PersonController::class, 'all']);
    Route::get('/login', [AuthController::class, 'login']);
   
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.guard:admin-api');


    Route::group(['middleware' => ['api', 'checkPassword'], 'prefix'=> 'user']
    , function(){
        Route::post('/login', [AuthController::class, 'userLogin']);
        Route::post('/logout', [AuthController::class, 'userLogout'])->middleware('auth.guard:user-api');
        Route::get('user-only', function(){
           if(! auth('api')->check())
           {
            return response()->json("No user Logged In");
           }

           return response()->json("This route is for users only");
        })->middleware('auth.guard:user-api');
    }
);

    

    

});




Route::post('locale', function(){
    //Localization
    //See SwitchLanguage Middleware
    return  Category::select('id', 'name_'.app()->getLocale().' as name')->get();
}) -> middleware(['lang', 'api']); 


