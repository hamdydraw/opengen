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
    'taxrate' =>'API\TaxRateController',
    'weightclass' =>'API\WeightclassController',
    'lengthclass' =>'API\LengthclassController',
    'merchant' =>'API\Merchant\MerchantController',
    'merchanttype' =>'API\MerchantTypeController',
    'pilot' =>'API\PilotController',
    'product' =>'API\ProductController',
    'attribute' =>'API\AttributeController',
    'attributegroups' =>'API\AttributeGroupController',
    'orders' =>'API\OrderController',
    'question' =>'API\QuestionController',
    'evaluation' =>'API\EvaluationController',
    'tripstiming' =>'API\TripstimingController',
]);


Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
Route::get('findUser','API\UserController@findUser');
Route::get('userslookups','API\UserController@userslookups');

Route::get('categorylookups','API\CategoryController@categorylookups');
Route::get('getCategory/{id}','API\CategoryController@getCategory');
Route::get('getCurrency/{id}','API\CurrencyController@getCurrency');
Route::get('getLanguage/{id}','API\LanguageController@getLanguage');
Route::get('getWeightclass/{id}','API\WeightclassController@getWeightclass');
Route::get('getLengthclass/{id}','API\LengthclassController@getLengthclass');
Route::get('getTaxrate/{id}','API\TaxRateController@getTaxrate');

Route::get('merchantlookups','API\Merchant\MerchantController@merchantlookups');
Route::get('getmerchant/{id}','API\Merchant\MerchantController@getMerchant');
Route::get('getzones/{id}','API\Merchant\MerchantController@getzones');

Route::get('getmerchanttype/{id}','API\MerchantTypeController@getMerchantType');
Route::get('getquestion/{id}','API\QuestionController@getQuestion');

Route::get('getproductalert','API\HomeController@getProductAlert');

Route::get('getpilot/{id}','API\PilotController@getPilot');

Route::get('gettripstiming/{id}','API\TripstimingController@gettripstiming');

Route::get('settings','API\HomeController@settings');
Route::put('updatesettings/{id}','API\HomeController@updatesettings');

Route::get('getevaluation/{id}','API\EvaluationController@getEvaluation');

Route::get('productlookups','API\ProductController@productlookups');
Route::get('getproduct/{id}','API\ProductController@getProduct');
Route::get('findProduct','API\ProductController@findProduct');
Route::put('updatequantity/{id}','API\ProductController@updatequantity');
Route::post('searchproduct','API\ProductController@searchproduct');

Route::get('orderlookups','API\OrderController@orderlookups');
Route::get('getorder/{id}','API\OrderController@getOrder');
Route::get('findOrder','API\OrderController@findOrder'); 
Route::post('searchorders','API\OrderController@searchorders');
Route::put('addHistory/{id}','API\OrderController@addHistory');


Route::get('attributelookups','API\AttributeController@attributelookups');
Route::get('getattribute/{id}','API\AttributeController@getAttribute');

Route::get('getattributegroup/{id}','API\AttributeGroupController@getAttributeGroup');

