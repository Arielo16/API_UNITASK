<?php

namespace App\Core\Goods\Repositories;

use App\Core\Goods\Entities\GoodEntity;

interface GoodRepositoryInterface
{
    public function getByCategoryId($categoryID): array;
}
