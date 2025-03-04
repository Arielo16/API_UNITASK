<?php

namespace App\Core\Materials\Entities;

class MaterialEntity
{
    public $materialID;
    public $name;
    public $supplier;
    public $quantity;
    public $price;
    public $diagnosticID;

    public function __construct($materialID, $name, $supplier, $quantity, $price, $diagnosticID)
    {
        $this->materialID = $materialID;
        $this->name = $name;
        $this->supplier = $supplier;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->diagnosticID = $diagnosticID;
    }
}
