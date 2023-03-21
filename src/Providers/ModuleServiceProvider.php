<?php

namespace Webkul\Article\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\Article\Models\Blog::class,
        \Webkul\Article\Models\Category::class,
        \Webkul\Article\Models\Tag::class,
        \Webkul\Article\Models\Comment::class,
    ];
}