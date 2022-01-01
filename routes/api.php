<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/grupos', 'API\GroupsController@getGroups');
Route::get('/discipulados', 'API\GroupsController@getDisciplesGroups');
Route::get('/miembro-grupo', 'API\GroupsController@getGroupsMembers');
Route::get('/grupos-tipo', 'API\GroupsController@getGroupsTypes');

Route::get('/faltas', 'API\AssistanceController@ReportAssistanceService');

Route::get('/login', 'API\AuthController@login');