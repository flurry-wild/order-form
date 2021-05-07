<?php

Route::get('/', 'OrderController@create')->name('order-create');
Route::post('/store', 'OrderController@store')->name('order-store');
Route::post('/forbidden-rate-days/{rateId}', 'OrderController@forbiddenRateDays')->name('forbidden-rate-days');
Route::post('/address-hints', 'OrderController@addressHints')->name('address-hints');


Route::resource('notes', 'NotesController');
