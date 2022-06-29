<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Blogs
      |--------------------------------------------------------------------------
      |
      | All ACLs related to blogs will be placed here.
      |
      */
    [
        'key' => 'blog',
        'name' => 'blog::app.blog.title',
        'route' => 'admin.blog.index',
        'sort' => 5,
    ], [
        'key' => 'blog.category',
        'name' => 'blog::app.category.title',
        'route' => 'admin.blog.category.index',
        'sort' => 2,
    ], [
        'key' => 'blog.tag',
        'name' => 'blog::app.tag.title',
        'route' => 'admin.blog.tag.index',
        'sort' => 3,
    ], [
        'key' => 'blog.comment',
        'name' => 'blog::app.comment.title',
        'route' => 'admin.blog.comment.index',
        'sort' => 4,
    ],
];
