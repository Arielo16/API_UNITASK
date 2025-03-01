<?php

namespace App\Core\Rooms\UseCases;

use App\Core\Rooms\Repositories\RoomRepositoryInterface;
use Exception;

class GetRoomsByBuildingId
{
    private $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function execute($buildingID): array
    {
        try {
            return $this->roomRepository->getByBuildingId($buildingID);
        } catch (Exception $e) {
            throw new Exception('Error fetching rooms by building ID: ' . $e->getMessage());
        }
    }
}
