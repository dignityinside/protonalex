<?php

return [
    [
        'title' => 'Hello world!',
        'content' => 'My first blog post.',
        'allow_comments' => '1',
        'status_id' => '0',
        'ontop' => \app\models\post\Post::SHOW_ON_TOP,
        'meta_description' => 'Hello World meta description',
        'slug' => 'hello-world',
        'category_id' => '1',
        'premium' => '0',
        'datecreate' => time(),
    ],
    [
        'title' => 'Premium post',
        'content' => 'My first premium blog post.',
        'allow_comments' => '1',
        'status_id' => '1',
        'ontop' => \app\models\post\Post::SHOW_ON_TOP,
        'meta_description' => 'Premium post meta description',
        'slug' => 'premium-post',
        'category_id' => '1',
        'premium' => '1',
        'datecreate' => time(),
    ],
];
