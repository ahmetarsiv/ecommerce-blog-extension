<?php

Route::group([
    'prefix' => 'blog',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {

    Route::get('/', 'Webkul\Article\Http\Controllers\Shop\ArticleController@index')->defaults('_config', [
        'view' => 'blog::shop.index',
    ])->name('shop.article.index');

    Route::get('/{slug}/{blog_slug?}', 'Webkul\Article\Http\Controllers\Shop\ArticleController@view')->defaults('_config', [
        'view' => 'blog::shop.view',
    ])->name('shop.article.view');
});