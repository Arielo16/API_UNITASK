<?php

namespace App\Infrastructure\Persistence;

use App\Models\Good;
use App\Core\Goods\Entities\GoodEntity;
use App\Core\Goods\Repositories\GoodRepositoryInterface;
use Exception;

class GoodRepository implements GoodRepositoryInterface
{
    public function getByCategoryId($categoryID): array
    {
        try {
            $goods = Good::where('categoryID', $categoryID)->get();
            return $goods->map(function ($good) {
                return new GoodEntity(
                    $good->goodID,
                    $good->name,
                    $good->categoryID
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching goods by category ID: ' . $e->getMessage());
        }
    }
}
