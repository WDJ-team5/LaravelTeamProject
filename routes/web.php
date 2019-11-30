<?php

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

/* 홈 화면 */
Route::get('/', [
	'as' => 'home',
	'uses' => 'HomeController@index'
]);

/* 사용자 가입 */
Route::get('auth/register', [//가입 폼으로 이동
    'as' => 'users.create',
    'uses' => 'UsersController@create',
]);
Route::post('auth/register', [//가입신청
    'as' => 'users.store',
    'uses' => 'UsersController@store',
]);
Route::get('auth/confirm/{code}', [//가입인증
    'as' => 'users.confirm',
    'uses' => 'UsersController@confirm',
]);

/* 사용자 인증 */
Route::get('auth/login', [//로그인 폼으로 이동
    'as' => 'sessions.create',
    'uses' => 'SessionsController@create',
]);
Route::post('auth/login', [//로그인요청
    'as' => 'sessions.store',
    'uses' => 'SessionsController@store',
]);
Route::get('auth/logout', [//로그아웃요청
    'as' => 'sessions.destroy',
    'uses' => 'SessionsController@destroy',
]);