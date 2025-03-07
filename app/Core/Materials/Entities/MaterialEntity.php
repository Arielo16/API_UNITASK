<?php

namespace App\Core\Materials\Entities;

class MaterialEntity
{
    public $materialID;
    public $name;

    public function __construct($materialID, $name)
    {
        $this->materialID = $materialID;
        $this->name = $name;
    }
}
