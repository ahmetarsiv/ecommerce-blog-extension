<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\Blog as BlogContract;
use Webkul\Core\Models\ChannelProxy;

class Blog extends Model implements BlogContract
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'channels',
        'default_category',
        'author',
        'tags',
        'image',
        'status',
        'locale',
        'allow_comments',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('Webkul\Blog\Models\Category', 'id', 'category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tag()
    {
        return $this->hasOne('Webkul\Blog\Models\Tag', 'id', 'tag');
    }

    /**
     * Get the channels.
     */
    public function channels()
    {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'channels');
    }
}