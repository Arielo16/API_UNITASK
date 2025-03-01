<?php

namespace App\Infrastructure\Persistence;

use App\Models\Category;
use App\Core\Categories\Entities\CategoryEntity;
use App\Core\Categories\Repositories\CategoryRepositoryInterface;
use Exception;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): array
    {
        try {
            $categories = Category::all();
            return $categories->map(function ($category) {
                return new CategoryEntity(
                    $category->categoryID,
                    $category->name
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching categories: ' . $e->getMessage());
        }
    }
}
