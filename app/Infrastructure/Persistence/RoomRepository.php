<?php

namespace App\Infrastructure\Persistence;

use App\Models\Room;
use App\Core\Rooms\Entities\RoomEntity;
use App\Core\Rooms\Repositories\RoomRepositoryInterface;
use Exception;

class RoomRepository implements RoomRepositoryInterface
{
    public function getByBuildingId($buildingID): array
    {
        try {
            $rooms = Room::where('buildingID', $buildingID)->get();
            return $rooms->map(function ($room) {
                return new RoomEntity(
                    $room->roomID,
                    $room->name,
                    $room->identifier,
                    $room->buildingID,
                    $room->typeID
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching rooms by building ID: ' . $e->getMessage());
        }
    }
}
