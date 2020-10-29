<?php

require_once __DIR__ . '/Models/QueryBuilder.php';
require_once __DIR__ . '/Models/Post.php';
require_once __DIR__ . '/Facades/Post.php';

use Ivans\Facades\Post;

echo '<pre>';
$a = Post::where('author', '1')->get();
var_dump($a);

Post::where(function ($query) {
    $query->taxonomy('category');
    $query->field('slug');
    $query->terms(['terms1']);
    $query->operator('NOT IN');
    return $query;
})->orWhere(function ($query) {
    $query->taxonomy('post_format');
    $query->field('slug');
    $query->terms(['terms2']);
    return $query;
})->get();

// This WILL work
$exclude_ids = array(1, 2, 3);
$query = new WP_Query(array('post__not_in' => $exclude_ids));

Post::taxonomy('category', function($query){
    $query->whereIn([16], 'term_id')->whereNotIn([19], 'term_id');
})->orTaxonomy('portfolio_category', function($query){
    $query->whereIn([32], 'term_id')->whereNotIn([34], 'term_id');
})->get();

Post::taxonomy('category', function ($query) {
    $query->where();
});

Post::taxonomy('category', 'a');

wp_die();
