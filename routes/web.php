<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('posts','PostController');

//Trash recycle
Route::get('/recycle-posts','PostController@trash')->name('posts.trash');
Route::get('/recycle-posts/{id}','PostController@restore')->name('posts.restore');
Route::post('/recycle-posts','PostController@remove')->name('posts.remove');


Route::get('/assign-posts/{url}','PostController@assign');