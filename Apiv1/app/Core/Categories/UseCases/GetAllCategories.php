<?php

namespace App\Core\Categories\UseCases;

use App\Core\Categories\Repositories\CategoryRepositoryInterface;
use Exception;

class GetAllCategories
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(): array
    {
        try {
            return $this->categoryRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error fetching all categories: ' . $e->getMessage());
        }
    }
}
