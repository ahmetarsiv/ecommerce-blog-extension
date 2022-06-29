<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\Comment as CommentContract;

class Comment extends Model implements CommentContract
{
    use HasFactory;

    protected $table = 'blog_comments';

    protected $fillable = [
        'post',
        'author',
        'email',
        'comment',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function blog()
    {
        return $this->hasOne('Webkul\Blog\Models\Blog', 'id', 'post');
    }
}