<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello',array('test'=>13));
});

Route::get('/test', function()
{
	return View::make('test',array('test'=>13));
});


Route::controller('mega', 'MegaController');

//Route::resource('mega/home/{id?}', 'MegaController');


Route::group(
    array('prefix' => 'admin'), 
    function() {
        Route::controller('admin', 'Admin\AdminController');
    }
);




Route::resource('home/{id?}', 'HomeController@showWelcome');
