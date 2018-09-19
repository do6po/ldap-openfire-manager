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

Route::group([
    'namespace' => 'Auth',
], function () {
    $this->get('login', 'LoginController@showLoginForm')->name('login');
    $this->post('login', 'LoginController@login');
    $this->post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::group([
    'prefix' => 'ldap',
    'namespace' => 'LDAP',
    'as' => 'ldap.',
    'middleware' => 'auth',
], function () {
    Route::get('/', 'LDAPController@index')->name('index');
    Route::get('/create', 'LDAPController@create')->name('create');
    Route::post('/', 'LDAPController@store')->name('store');
    Route::get('/{ldap}', 'LDAPController@show')->name('show');
    Route::get('/{ldap}/edit', 'LDAPController@edit')->name('edit');
    Route::put('/{ldap}', 'LDAPController@update')->name('update');
    Route::delete('/{ldap}', 'LDAPController@destroy')->name('destroy');

    Route::get('/{ldap}/test', 'TestConnectionController@test')->name('test');

    Route::group([
        'prefix' => 'roster',
        'as' => 'roster.',
    ], function () {
        Route::get('/', 'RosterController@index')->name('index');
        Route::post('/', 'RosterController@store')->name('store');
        Route::delete('/{roster}', 'RosterController@destroy')->name('destroy');
        Route::get('/{roster}', 'RosterController@show')->name('show');
        Route::put('/{roster}', 'RosterController@update')->name('update');

    });
});


