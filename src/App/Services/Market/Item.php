<?php


namespace App\Services\Market;


class Item
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function __invoke($params)
    {
        return $this->order;
    }
}