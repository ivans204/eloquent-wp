<?php

namespace Ivans\Facades;

use Ivans\Models\Page as PageModel;

class Page
{
    public static function __callStatic($name, $arguments)
    {
        $page = new PageModel;

        if (method_exists($page, $name)) {
            return $page->$name($arguments);
        }
    }
}