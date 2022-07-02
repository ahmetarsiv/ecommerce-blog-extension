<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Shop\ShopBlogController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    /**
     * Shop blog routes
     */
    Route::get('blog', [ShopBlogController::class, 'index'])->defaults('_config', [
        'view' => 'blog::shop.blogs.index',
    ])->name('shop.blog.index');

    Route::get('/blog/{id}', [ShopBlogController::class, 'single'])->defaults('_config', [
        'view' => 'blog::shop.blogs.single',
    ])->name('shop.blog.single');

    Route::get('/blog/{id}', [ShopBlogController::class, 'category'])->defaults('_config', [
        'view' => 'blog::shop.blogs.index',
    ])->name('shop.blog.category');

});
