<?php

Route::group([
    'prefix' => config('queue-ui.route_prefix', 'queue'),
    'middleware' => config('queue-ui.route_middleware', 'admin'),
    'namespace' => '\\EngineDigital\\QueueUi\\Http\\Controllers',
], function() {
    Route::get('/', 'QueueUiController@index')->name('queue-ui.index');
    Route::get('/run', 'QueueUiController@run')->name('queue-ui.run');
});
