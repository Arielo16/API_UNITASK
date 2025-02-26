<?php

namespace App\Core\Buildings\Repositories;

use App\Core\Buildings\Entities\BuildingEntity;

interface BuildingRepositoryInterface
{
    public function getAll(): array;
    public function getById($id): ?BuildingEntity;
}
