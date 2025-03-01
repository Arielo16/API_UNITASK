<?php

namespace App\Infrastructure\Persistence;

use App\Models\Building;
use App\Core\Buildings\Entities\BuildingEntity;
use App\Core\Buildings\Repositories\BuildingRepositoryInterface;
use Exception;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function getAll(): array
    {
        try {
            $buildings = Building::all();
            return $buildings->map(function ($building) {
                return new BuildingEntity($building->buildingID, $building->name, $building->identifier);
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching buildings: ' . $e->getMessage());
        }
    }

    public function getById($id): ?BuildingEntity
    {
        try {
            $building = Building::find($id);
            if ($building) {
                return new BuildingEntity($building->buildingID, $building->name, $building->identifier);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Error fetching building by ID: ' . $e->getMessage());
        }
    }
}
