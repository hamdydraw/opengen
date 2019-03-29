<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources([
    'user' => 'API\UserController',
    'category' =>'API\CategoryController',
    'currency' =>'API\CurrencyController',
    'language' =>'API\LanguageController',
    'weightclass' =>'API\WeightclassController',
    'lengthclass' =>'API\LengthclassController',
]);
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
Route::get('findUser','API\UserController@findUser');

Route::get('categorylookups','API\CategoryController@categorylookups');
Route::get('getCategory/{id}','API\CategoryController@getCategory');
Route::get('getCurrency/{id}','API\CurrencyController@getCurrency');
Route::get('getLanguage/{id}','API\LanguageController@getLanguage');
Route::get('getWeightclass/{id}','API\WeightclassController@getWeightclass');
Route::get('getLengthclass/{id}','API\LengthclassController@getLengthclass');