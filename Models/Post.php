<?php

namespace Ivans\Models;

class Post extends QueryBuilder
{
    public function __construct()
    {
        $this->post_type = 'post';
    }
}