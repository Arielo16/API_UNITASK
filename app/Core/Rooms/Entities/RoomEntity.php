<?php

namespace App\Core\Rooms\Entities;

class RoomEntity
{
    public $roomID;
    public $name;
    public $identifier;
    public $buildingID;
    public $typeID;

    public function __construct($roomID, $name, $identifier, $buildingID, $typeID)
    {
        $this->roomID = $roomID;
        $this->name = $name;
        $this->identifier = $identifier;
        $this->buildingID = $buildingID;
        $this->typeID = $typeID;
    }
}
