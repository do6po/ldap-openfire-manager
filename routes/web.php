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

Route::resource('/ldap', 'LDAP\ServerController');

Route::get('/ldap/test/{ldap}', 'LDAP\TestConnectionController@test')->name('ldap.test');