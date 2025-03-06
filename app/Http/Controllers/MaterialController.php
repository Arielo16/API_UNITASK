<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Materials\UseCases\GetAllMaterials;
use Exception;

class MaterialController extends Controller
{
    private $getAllMaterials;

    public function __construct(GetAllMaterials $getAllMaterials)
    {
        $this->getAllMaterials = $getAllMaterials;
    }

    public function index()
    {
        try {
            $materials = $this->getAllMaterials->execute();
            return response()->json(['materials' => $materials], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
