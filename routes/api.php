<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes (v1)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->prefix('/v1')->namespace('Api\V1')->group(function () {
    Route::get('users/profile', 'UserController@profile')->name('profileApi');
    Route::get('memos', 'MemoController@index')->name('memosApi');
    Route::get('memos/{memo}', 'MemoController@show')->name('memoApi');
});