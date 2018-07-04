<?php

/**
 * Quick and dirty converter from wordpress to our system
 */

// Show errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include autoloader
require_once 'vendor/autoload.php';

// Include db config
$config = require '../../config/db.php';

use Dignity\DatabaseHelper;

$db = DatabaseHelper::getInstance($config['dsn'], $config['username'], $config['password']);

/**
 * Save post
 *
 * @param $db
 */
function post($db)
{

    $new = [];
    $i = 0;

    $res = $db->select('SELECT id, post_author, post_date, post_content, post_title, post_name FROM wp_posts WHERE post_type = "post" AND post_status = "publish" AND post_content <> ""');

    foreach ($res as $post) {

        $i++;

        $new[$i]['title'] = $post['post_title'];
        $new[$i]['slug'] = $post['post_name'];
        $new[$i]['content'] = replaceMore($post['post_content']);
        $new[$i]['status_id'] = 1;
        $new[$i]['datecreate'] = strtotime($post['post_date']);
        $new[$i]['dateupdate'] = strtotime($post['post_date']);
        $new[$i]['category_id'] = 0;
        $new[$i]['user_id'] = $post['post_author'];
        $new[$i]['allow_comments'] = 1;
        $new[$i]['ontop'] = 1;

        // get comments
        comments($db, $post['id'], $i);

    }

    foreach ($new as $post) {
        $db->insert('post', $post);
    }

}

/**
 * Returns comments by post id
 *
 * @TODO: tree-like comments currently not working. We don't know the last comment id, for get parent_id
 *
 * @param $db
 * @param $postId
 * @param $newPostId
 *
 * @return array|void
 */
function comments($db, $postId, $newPostId)
{

    $new = [];

    $i = 0;

    $res = $db->select("SELECT comment_post_id, comment_author, comment_author_email, comment_author_ip, comment_date, comment_content, comment_parent, user_id FROM wp_comments INNER JOIN wp_posts ON wp_comments.comment_post_id = wp_posts.id WHERE wp_posts.post_status = 'publish' AND wp_posts.post_content <> '' AND wp_posts.post_type = 'post' AND comment_approved = 1 AND comment_post_id = $postId");

    if ($res < 0) return;

    foreach ($res as $comment) {

        $i++;

        $new[$i]['material_type'] = 1;
        $new[$i]['material_id'] = $newPostId;
        $new[$i]['text'] = replaceMore($comment['comment_content']);
        $new[$i]['user_id'] = $comment['user_id'];
        $new[$i]['user_name'] = $comment['comment_author'];
        $new[$i]['user_email'] = $comment['comment_author_email'];
        $new[$i]['user_ip'] = $comment['comment_author_ip'];
        $new[$i]['parent_id'] = 0;
        $new[$i]['is_approved'] = 1;
        $new[$i]['created_at'] = $comment['comment_date'];
        $new[$i]['updated_at'] = strtotime($comment['comment_date']);


    }

    foreach ($new as $newComment) {
        $db->insert('comments', $newComment);
    }

    return $new;

}

/**
 * Replace more tag (currently we remove this tag)
 *
 * @param $text
 *
 * @return mixed|string
 */
function replaceMore($text)
{

    $text = str_replace('<!--more-->', '[cut]', $text);
    $text = str_replace('</pre>', "\n```\n", $text);
    $text = htmlspecialchars_decode($text);

    return $text;

}

post($db);
