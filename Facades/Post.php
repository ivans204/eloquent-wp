<?php

namespace Ivans\Facades;

use Ivans\Models\Post as PostModel;

class Post
{
    public static function __callStatic($name, $arguments)
    {
        $post = new PostModel;

        if (method_exists($post, $name)) {
            return $post->$name($arguments);
        }
        else {
            echo 'nema';
        }
    }
}