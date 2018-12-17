<?php

Route::group([
    'namespace' => 'InetStudio\Links\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::get('links/widget', 'LinksControllerContract@getItemsByIDs')->name('back.links.widget.get');

    Route::resource('links', 'LinksControllerContract', ['as' => 'back']);
});
