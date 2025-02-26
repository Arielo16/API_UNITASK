<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Buildings\UseCases\GetAllBuildings;
use App\Core\Buildings\UseCases\GetBuildingById;
use Exception;

class BuildingController extends Controller
{
    private $getAllBuildings;
    private $getBuildingById;

    public function __construct(GetAllBuildings $getAllBuildings, GetBuildingById $getBuildingById)
    {
        $this->getAllBuildings = $getAllBuildings;
        $this->getBuildingById = $getBuildingById;
    }

    public function index()
    {
        try {
            $buildings = $this->getAllBuildings->execute();
            return response()->json(['buildings' => $buildings], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $building = $this->getBuildingById->execute($id);
            if ($building) {
                return response()->json(['building' => $building], 200);
            } else {
                return response()->json(['message' => 'Building not found'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
