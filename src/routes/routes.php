<?php

Route::group(['prefix' => 'ahhprovinsi', 'middleware' => 'web'], function() {
    Route::get('/', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getIndex');
    Route::get('/list', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getList');
    Route::get('/detail/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@detailAhhProvinsi');
    Route::post('/create', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@createAhhProvinsiSave');
    Route::get('/update/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@updateAhhProvinsi');
    Route::post('/update/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getIndex');
    Route::post('/delete/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getIndex');
    Route::post('/activate/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getIndex');
    Route::post('/unactivate/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getIndex');
    Route::get('/getKota/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getKota');
    Route::get('/json/{id}/{va}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@json');
    Route::get('/export/{id}', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@export');
    Route::get('/getColumns', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getColumns');
    Route::get('/getProvinsi', 'Satudata\Ahhprovinsi\Http\Controllers\AhhProvinsiController@getProvinsi');
});
