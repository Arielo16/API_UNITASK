<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Categories\UseCases\GetAllCategories;
use Exception;

class CategoryController extends Controller
{
    private $getAllCategories;

    public function __construct(GetAllCategories $getAllCategories)
    {
        $this->getAllCategories = $getAllCategories;
    }

    public function index()
    {
        try {
            $categories = $this->getAllCategories->execute();
            return response()->json(['categories' => $categories], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
