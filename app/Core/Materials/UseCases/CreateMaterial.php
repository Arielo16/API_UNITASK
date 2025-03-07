<?php

namespace App\Core\Materials\UseCases;

use App\Core\Materials\Repositories\MaterialRepositoryInterface;
use App\Core\Materials\Entities\MaterialEntity;
use Exception;

class CreateMaterial
{
    private $materialRepository;

    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute(array $data): MaterialEntity
    {
        try {
            return $this->materialRepository->create($data); // Corregir la llamada al método create
        } catch (Exception $e) {
            throw new Exception('Error creating material: ' . $e->getMessage());
        }
    }
}
