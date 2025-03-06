<?php

namespace App\Infrastructure\Persistence;

use App\Models\Material;
use App\Core\Materials\Entities\MaterialEntity;
use App\Core\Materials\Repositories\MaterialRepositoryInterface;
use Exception;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function create(array $data): MaterialEntity
    {
        try {
            $material = Material::create($data);
            return new MaterialEntity(
                $material->materialID,
                $material->name,
                $material->supplier,
                $material->quantity,
                $material->price,
                $material->diagnosticID
            );
        } catch (Exception $e) {
            throw new Exception('Error creating material: ' . $e->getMessage());
        }
    }

    public function find($materialID)
    {
        return Material::find($materialID);
    }

    public function getAll(): array
    {
        try {
            $materials = Material::all();
            return $materials->map(function ($material) {
                return new MaterialEntity(
                    $material->materialID,
                    $material->name,
                    $material->supplier,
                    $material->quantity,
                    $material->price,
                    $material->diagnosticID
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching materials: ' . $e->getMessage());
        }
    }
}
