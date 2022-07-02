<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Admin\AdminBlogController;
use Webkul\Blog\Http\Controllers\Admin\AdminCategoryController;
use Webkul\Blog\Http\Controllers\Admin\AdminTagController;
use Webkul\Blog\Http\Controllers\Admin\AdminCommentController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

    /**
     * Admin blog routes
     */
    Route::get('blog', [AdminBlogController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.blogs.index',
    ])->name('admin.blog.index');

    Route::get('blog/create', [AdminBlogController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.blogs.create',
    ])->name('admin.blog.create');

    Route::get('/blog/edit/{id}', [AdminBlogController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.blogs.edit',
    ])->name('admin.blog.edit');

    Route::post('blog/store', [AdminBlogController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.store');

    Route::post('/blog/update/{id}', [AdminBlogController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.update');

    Route::post('/blog/delete/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blog.delete');

    Route::post('blog/massdelete', [AdminBlogController::class, 'massDestroy'])->name('admin.blog.massdelete');

    /**
     * Admin category routes
     */
    Route::get('category', [AdminCategoryController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.categories.index',
    ])->name('admin.blog.category.index');

    Route::get('category/create', [AdminCategoryController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.categories.create',
    ])->name('admin.blog.category.create');

    Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.categories.edit',
    ])->name('admin.blog.category.edit');

    Route::post('category/store', [AdminCategoryController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.store');

    Route::post('/category/update/{id}', [AdminCategoryController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.update');

    Route::post('/category/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.blog.category.delete');

    Route::post('category/massdelete', [AdminCategoryController::class, 'massDestroy'])->name('admin.blog.category.massdelete');

    /**
     * Admin tag routes
     */
    Route::get('tag', [AdminTagController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.tags.index',
    ])->name('admin.blog.tag.index');

    Route::get('tag/create', [AdminTagController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.tags.create',
    ])->name('admin.blog.tag.create');

    Route::get('/tag/edit/{id}', [AdminTagController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.tags.edit',
    ])->name('admin.blog.tag.edit');

    Route::post('tag/store', [AdminTagController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.store');

    Route::post('/tag/update/{id}', [AdminTagController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.update');

    Route::post('/tag/delete/{id}', [AdminTagController::class, 'destroy'])->name('admin.blog.tag.delete');

    Route::post('tag/massdelete', [AdminTagController::class, 'massDestroy'])->name('admin.blog.tag.massdelete');

    /**
     * Admin comment routes
     */
    Route::get('comment', [AdminCommentController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.comments.index',
    ])->name('admin.blog.comment.index');

    Route::get('/comment/edit/{id}', [AdminCommentController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.comments.edit',
    ])->name('admin.blog.comment.edit');

    Route::post('/comment/update/{id}', [AdminCommentController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.comment.index',
    ])->name('admin.blog.comment.update');

    Route::post('comment/delete/{id}', [AdminCommentController::class, 'destroy'])->name('admin.blog.comment.delete');

    Route::post('comment/massdelete', [AdminCommentController::class, 'massDestroy'])->name('admin.blog.comment.massdelete');
});