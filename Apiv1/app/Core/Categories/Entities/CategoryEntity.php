<?php

namespace App\Core\Categories\Entities;

class CategoryEntity
{
    public $categoryID;
    public $name;

    public function __construct($categoryID, $name)
    {
        $this->categoryID = $categoryID;
        $this->name = $name;
    }
}
