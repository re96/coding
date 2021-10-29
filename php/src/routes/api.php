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

Route::prefix('/auth')->namespace('Auth')->group(function() {

    // 회원 로그인
    Route::post('/login', 'LoginController@login');

    // 회원 로그아웃
    Route::middleware('auth:api')->post('/logout', 'LoginController@logout');
});

Route::prefix('/users')->namespace('User')->group(function() {

    // 회원 목록 조회
    Route::get('/', 'UserController@index');

    // 회원 가입
    Route::post('/', 'UserController@store');

    // 회원 상세
    Route::prefix('/{user_id}')->where(['user_id' => '[0-9]+'])->group(function() {

        // 단일 회원 주문
        Route::prefix('/orders')->group(function() {

            // 단일 회원 주문 목록 조회
            Route::get('/', 'OrderController@index');

            // 단일 회원 주문 생성
            Route::post('/', 'OrderController@store');

            // 단일 회원 주문 상세 조회
            Route::get('/{order_id}', 'OrderController@show')->where(['order_id' => '[0-9]+']);
        });
    });
});
