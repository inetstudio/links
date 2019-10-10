<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\LinksPackage\Links\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back',
    ],
    function () {
        Route::get('links/widget', 'ItemsControllerContract@getItemsByIds')->name('back.links.get');

        Route::resource('links', 'ResourceControllerContract', ['as' => 'back']);
    }
);
