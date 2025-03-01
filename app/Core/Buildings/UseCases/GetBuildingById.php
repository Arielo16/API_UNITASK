<?php

namespace App\Core\Buildings\UseCases;

use App\Core\Buildings\Repositories\BuildingRepositoryInterface;
use Exception;

class GetBuildingById
{
    private $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    public function execute($id)
    {
        try {
            return $this->buildingRepository->getById($id);
        } catch (Exception $e) {
            throw new Exception('Error fetching building by ID: ' . $e->getMessage());
        }
    }
}
