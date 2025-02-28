<?php

namespace App\Core\Categories\Repositories;

use App\Core\Categories\Entities\CategoryEntity;

interface CategoryRepositoryInterface
{
    public function getAll(): array;
}
