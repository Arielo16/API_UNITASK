<?php

namespace App\Core\Goods\Entities;

class GoodEntity
{
    public $goodID;
    public $name;
    public $categoryID;

    public function __construct($goodID, $name, $categoryID)
    {
        $this->goodID = $goodID;
        $this->name = $name;
        $this->categoryID = $categoryID;
    }
}
