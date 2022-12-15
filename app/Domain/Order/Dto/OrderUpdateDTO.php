<?php

namespace App\Domain\Order\Dto;

class OrderUpdateDto
{
    private array $data;

    public function __construct (array $data)
    {
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }
}
