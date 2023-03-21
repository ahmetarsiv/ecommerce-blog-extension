<?php

use Illuminate\Support\Facades\Route;
use Webkul\Article\Http\Controllers\Admin\BlogController;
use Webkul\Article\Http\Controllers\Admin\CategoryController;
use Webkul\Article\Http\Controllers\Admin\TagController;
use Webkul\Article\Http\Controllers\Admin\CommentController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

    /**
     * Admin blog routes
     */
    Route::get('blog', [BlogController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.blogs.index',
    ])->name('admin.blog.index');

    Route::get('blog/create', [BlogController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.blogs.create',
    ])->name('admin.blog.create');

    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.blogs.edit',
    ])->name('admin.blog.edit');

    Route::post('blog/store', [BlogController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.store');

    Route::post('/blog/update/{id}', [BlogController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.update');

    Route::post('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('admin.blog.delete');

    Route::post('blog/massdelete', [BlogController::class, 'massDestroy'])->name('admin.blog.massdelete');

    /**
     * Admin category routes
     */
    Route::get('category', [CategoryController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.categories.index',
    ])->name('admin.blog.category.index');

    Route::get('category/create', [CategoryController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.categories.create',
    ])->name('admin.blog.category.create');

    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.categories.edit',
    ])->name('admin.blog.category.edit');

    Route::post('category/store', [CategoryController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.store');

    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.update');

    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.blog.category.delete');

    Route::post('category/massdelete', [CategoryController::class, 'massDestroy'])->name('admin.blog.category.massdelete');

    /**
     * Admin tag routes
     */
    Route::get('tag', [TagController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.tags.index',
    ])->name('admin.blog.tag.index');

    Route::get('tag/create', [TagController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.tags.create',
    ])->name('admin.blog.tag.create');

    Route::get('/tag/edit/{id}', [TagController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.tags.edit',
    ])->name('admin.blog.tag.edit');

    Route::post('tag/store', [TagController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.store');

    Route::post('/tag/update/{id}', [TagController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.update');

    Route::post('/tag/delete/{id}', [TagController::class, 'destroy'])->name('admin.blog.tag.delete');

    Route::post('tag/massdelete', [TagController::class, 'massDestroy'])->name('admin.blog.tag.massdelete');

    /**
     * Admin comment routes
     */
    Route::get('comment', [CommentController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.comments.index',
    ])->name('admin.blog.comment.index');

    Route::get('/comment/edit/{id}', [CommentController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.comments.edit',
    ])->name('admin.blog.comment.edit');

    Route::post('/comment/update/{id}', [CommentController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.comment.index',
    ])->name('admin.blog.comment.update');

    Route::post('comment/delete/{id}', [CommentController::class, 'destroy'])->name('admin.blog.comment.delete');

    Route::post('comment/massdelete', [CommentController::class, 'massDestroy'])->name('admin.blog.comment.massdelete');
});