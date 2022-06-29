<?php

namespace Webkul\Blog\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected $models = [
        \Webkul\Blog\Models\Blog::class,
        \Webkul\Blog\Models\Category::class,
        \Webkul\Blog\Models\Tag::class,
        \Webkul\Blog\Models\Comment::class,
    ];
}
