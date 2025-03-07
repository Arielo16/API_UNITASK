<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Materials\UseCases\GetAllMaterials;
use App\Core\Materials\UseCases\CreateMaterial;
use Exception;

class MaterialController extends Controller
{
    private $getAllMaterials;
    private $createMaterial;

    public function __construct(GetAllMaterials $getAllMaterials, CreateMaterial $createMaterial)
    {
        $this->getAllMaterials = $getAllMaterials;
        $this->createMaterial = $createMaterial;
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

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $data = $request->all();
            $material = $this->createMaterial->execute($data);

            return response()->json(['material' => $material], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
