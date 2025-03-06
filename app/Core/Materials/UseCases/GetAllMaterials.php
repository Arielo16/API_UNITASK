<?php

namespace App\Core\Materials\UseCases;

use App\Core\Materials\Repositories\MaterialRepositoryInterface;

class GetAllMaterials
{
    private $materialRepository;

    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute(): array
    {
        return $this->materialRepository->getAll();
    }
}
