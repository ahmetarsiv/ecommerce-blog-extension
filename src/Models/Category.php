<?php

namespace Webkul\Article\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Article\Contracts\Category as CategoryContract;

class Category extends Model implements CategoryContract
{
    use HasFactory;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
        'locale',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_at',
        'updated_at'
    ];

    public function blog()
    {
        return $this->hasMany(Blog::class, 'default_category');
    }
}