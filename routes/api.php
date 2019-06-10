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

    Route::post('login','API\UserController@login');
    Route::post('register','API\UserController@register');
    Route::post('logout','API\UserController@logout');
    Route::post('verifyuser','API\UserController@verifyuser');
    Route::post('sendnewpassword','API\UserController@sendnewpassword');
    Route::post('changepassword','API\UserController@changepassword');
    Route::get('deleteuser/{id}','API\UserController@destroy');

    Route::post('registersaloon','API\SallonRegistrationController@register');
    Route::post('updatesaloon','API\SallonRegistrationController@updatesaloon');
    Route::get('deletesaloon/{id}','API\SallonRegistrationController@destroy');

    Route::post('addservice','API\ServiceController@addservice');
    Route::get('showservice/{id}','API\ServiceController@showservice');
    Route::post('listservice','API\ServiceController@listservice');
    Route::post('updateservice','API\ServiceController@updateservice');
    Route::get('deleteservice/{id}','API\ServiceController@destroy');

    Route::post('addportfollio','API\PortfollioController@addportfollio');
    Route::get('showportfollio/{id}','API\PortfollioController@showportfollio');
    Route::post('listportfollio','API\PortfollioController@listportfollio');
    Route::post('updateportfollio','API\PortfollioController@updateportfollio');
    Route::get('deleteportfollio/{id}','API\PortfollioController@destroy');

    Route::post('addsaloonman','API\SaloonManController@addsaloonman');
    Route::post('listsaloonman','API\SaloonManController@listsaloonman');
    Route::get('deletesaloonman/{id}','API\SaloonManController@destroy');

    Route::post('addfavourite','API\FavouriteSaloonController@addfavourite');
    Route::get('getfavourite/{user_id}','API\FavouriteSaloonController@getfavourite');

    Route::get('searchsaloon/{name}/','API\UserController@searchsaloon'); 
    Route::get('nearybysaloon/{pincode}/','API\UserController@nearybysaloon'); 

    Route::post('addreview','API\UserController@addreview');

    Route::post('gettoken','API\UserController@gettoken');
    Route::post('availability','API\UserController@availability');
    Route::get('canceltoken/{id}','API\UserController@canceltoken');

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
