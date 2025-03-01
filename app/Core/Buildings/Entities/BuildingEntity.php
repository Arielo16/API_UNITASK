<?php

namespace App\Core\Buildings\Entities;

use Exception;

class BuildingEntity
{
    public $buildingID;
    public $name;
    public $identifier;

    public function __construct($buildingID, $name, $identifier)
    {
        if (empty($buildingID) || empty($name) || empty($identifier)) {
            throw new Exception('Invalid BuildingEntity data');
        }

        $this->buildingID = $buildingID;
        $this->name = $name;
        $this->identifier = $identifier;
    }
}
