<?php


namespace App\Services\Market;


class Market
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function __invoke()
    {
        return $this->order;
    }
}