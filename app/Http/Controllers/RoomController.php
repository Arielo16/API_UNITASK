<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Rooms\UseCases\GetRoomsByBuildingId;
use Exception;

class RoomController extends Controller
{
    private $getRoomsByBuildingId;

    public function __construct(GetRoomsByBuildingId $getRoomsByBuildingId)
    {
        $this->getRoomsByBuildingId = $getRoomsByBuildingId;
    }

    public function getByBuildingId($buildingID)
    {
        try {
            $rooms = $this->getRoomsByBuildingId->execute($buildingID);
            return response()->json(['rooms' => $rooms], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
