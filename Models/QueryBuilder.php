<?php


namespace Ivans\Models;

use WP_Query;

class TaxonomyQuery
{
    private $query = [];

    public function __call($name, $arguments)
    {
        if ($name !== 'getQueryArg') {
            $this->query[$name] = $arguments[0];
        }
        return $this->getQueryArg();
    }

    public function getQueryArg()
    {
        return $this->query;
    }
}

class QueryBuilder
{
    private $query = [];
    protected $post_type = '';

    function get()
    {
        print_r($this->query);
        return new WP_Query($this->query);
    }

    function all($per_page = -1)
    {
        $this->query['post_per_page'] = strval($per_page);
        var_dump($this->query);
        return new WP_Query($this->query);
    }

    private function tax_query($value)
    {
        if (is_callable($value)) {
            $WQB = new TaxonomyQuery;
            $taxElements = $value($WQB)->getQueryArg();
            $this->query['tax_query'][] = $taxElements;
            return $this;
        }
        return false;
    }

    function taxonomy($tax)
    {
        var_dump($tax);

//        if(is $tax[1])

        return $this;
    }

    function where($args)
    {
        $this->query['post_type'] = $this->post_type;

        $type = isset($args[0]) ? $args[0] : false;
        $operator = isset($args[1]) ? $args[1] : false;
        $value = isset($args[2]) ? $args[2] : false;

        $this->tax_query($type);

        $operators = [
            '>', '<', '=', '!=', '>=', '<=',
            'LIKE', 'NOT LIKE', 'IN', 'NOT IN',
            'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS'
        ];

        if (in_array(strtoupper($operator), $operators) && isset($value)) {
            $meta_query = [
                'post_type' => $this->post_type,
                'meta_key' => $type,
                'meta_compare' => $operator,
                'meta_value' => $value,
            ];
            $this->query['meta_query'] = $meta_query;
        } else if (isset($value)) {
            $this->query[$type] = $operator;
        }
        return $this;
    }

    function orWhere($args)
    {
        $this->query['tax_query']['relation'] = 'OR';
        $this->tax_query($args);
        return $this;
    }

    function andWhere($args)
    {
        $this->query['tax_query']['relation'] = 'AND';
        $this->tax_query($args);
        return $this;
    }

    function order($value = 'DESC')
    {
        $this->query['order'] = $value;
        return $this;
    }

    function orderby($value)
    {
        $this->query['order_by'] = $value;
        return $this;
    }

    function limit($num)
    {
        $this->query['posts_per_page'] = strlen($num);
        return $this;
    }

    function mostRecent($post_num)
    {
        $this->query['posts_per_page'] = $post_num;
        return $this;
    }

    function offset($offset_num)
    {
        $this->query['offset'] = $offset_num;
        return $this;
    }
}