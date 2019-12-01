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

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index',
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
])->where('code', '[\pL-\pN]{60}');

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

/* 비밀번호 초기화 */
Route::get('auth/remind', [//비밀번호 바꾸기 폼으로 이동
    'as' => 'remind.create',
    'uses' => 'PasswordsController@getRmind',
]);
Route::post('auth/remind', [//변경 요정
    'as' => 'remind.store',
    'uses' => 'PasswordsController@postRmind',
]);
Route::get('auth/reset/{token}', [
    'as' => 'reset.create',
    'uses' => 'PasswordsController@getReset',
]);
Route::post('auth/reset', [
    'as' => 'reset.store',
    'uses' => 'PasswordsController@postReset',
]);

