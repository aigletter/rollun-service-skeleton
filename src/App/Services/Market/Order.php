<?php


namespace App\Services\Market;


class Order
{
    public $id;

    protected $title;

    protected $items = [];

    public function __construct()
    {
        $this->id = rand(100000, 999999);

        $this->title = "Hello world";
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /*public function __invoke($var)
    {
        return ['test' => 'hello world'];
    }*/
}