<?php

namespace App\Core\Goods\UseCases;

use App\Core\Goods\Repositories\GoodRepositoryInterface;
use Exception;

class GetGoodsByCategoryId
{
    private $goodRepository;

    public function __construct(GoodRepositoryInterface $goodRepository)
    {
        $this->goodRepository = $goodRepository;
    }

    public function execute($categoryID): array
    {
        try {
            return $this->goodRepository->getByCategoryId($categoryID);
        } catch (Exception $e) {
            throw new Exception('Error fetching goods by category ID: ' . $e->getMessage());
        }
    }
}
