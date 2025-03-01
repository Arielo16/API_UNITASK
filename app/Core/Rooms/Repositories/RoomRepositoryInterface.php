<?php

namespace App\Core\Rooms\Repositories;

use App\Core\Rooms\Entities\RoomEntity;

interface RoomRepositoryInterface
{
    public function getByBuildingId($buildingID): array;
}
