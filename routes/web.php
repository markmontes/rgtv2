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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/accounts', 'AccountsController@index')->name('accounts');
Route::get('/reports', 'ReportsController@index')->name('reports');
Route::post('/reports/create/', 'ReportsController@create')->name('reports.create');
Route::post('/reports/edit/', 'ReportsController@edit')->name('reports.edit');
Route::get('/reports/manage/{id}', 'ReportsController@manage')->name('reports.manage');
Route::post('/reports/addrow', 'ReportsController@addrow')->name('reports.addrow');
Route::get('/reports/getcell', 'ReportsController@getcell')->name('reports.getcell');
Route::get('/reports/chartdata', 'ReportsController@chartdata')->name('reports.chartdata');
Route::post('/reports/updatecell', 'ReportsController@updatecell')->name('reports.updatecell');
Route::get('/reports/updaterep', 'ReportsController@updaterep')->name('reports.updaterep');
Route::get('/reports/manage/preview/{id}', 'ReportsController@preview')->name('reports.manage.preview');
Route::get('/reports/manage/download/{id}', 'ReportsController@download')->name('reports.manage.download');