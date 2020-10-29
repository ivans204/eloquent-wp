<?php


namespace Ivans\Models;

//use Ivans\Models\QueryBuilder as  QB;

class Page extends QueryBuilder
{
    public function __construct()
    {
        $this->post_type = 'page';
    }
}