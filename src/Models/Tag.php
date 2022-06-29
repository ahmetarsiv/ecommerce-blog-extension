<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\Tag as TagContract;

class Tag extends Model implements TagContract
{
    use HasFactory;

    protected $table = 'blog_tags';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'locale',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];
}