<?php

namespace App\Core\Buildings\UseCases;

use App\Core\Buildings\Repositories\BuildingRepositoryInterface;
use Exception;

class GetAllBuildings
{
    private $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    public function execute(): array
    {
        try {
            return $this->buildingRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error fetching buildings: ' . $e->getMessage());
        }
    }
}
