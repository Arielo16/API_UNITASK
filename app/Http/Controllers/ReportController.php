<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Reports\UseCases\GetAllReports;
use App\Core\Reports\UseCases\GetReportsByPriority;
use App\Core\Reports\UseCases\GetReportsByStatus;
use App\Core\Reports\UseCases\CreateReport;
use App\Core\Reports\UseCases\GetReportsByBuildingId;
use App\Core\Reports\UseCases\GetReportsOrderedByDate;
use App\Core\Reports\UseCases\GetReportByFolio;
use App\Core\Reports\UseCases\UpdateReport;
use App\Core\Reports\UseCases\UpdateReportStatus;
use Exception;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReportController extends Controller
{
    private $getAllReports;
    private $getReportsByPriority;
    private $getReportsByStatus;
    private $createReport;
    private $getReportsByBuildingId;
    private $getReportsOrderedByDate;
    private $getReportByFolio;
    private $updateReport;
    private $updateReportStatus;

    public function __construct(
        GetAllReports $getAllReports, 
        GetReportsByPriority $getReportsByPriority, 
        GetReportsByStatus $getReportsByStatus, 
        CreateReport $createReport,
        GetReportsByBuildingId $getReportsByBuildingId,
        GetReportsOrderedByDate $getReportsOrderedByDate,
        GetReportByFolio $getReportByFolio,
        UpdateReport $updateReport,
        UpdateReportStatus $updateReportStatus
    ) {
        $this->getAllReports = $getAllReports;
        $this->getReportsByPriority = $getReportsByPriority;
        $this->getReportsByStatus = $getReportsByStatus;
        $this->createReport = $createReport;
        $this->getReportsByBuildingId = $getReportsByBuildingId;
        $this->getReportsOrderedByDate = $getReportsOrderedByDate;
        $this->getReportByFolio = $getReportByFolio;
        $this->updateReport = $updateReport;
        $this->updateReportStatus = $updateReportStatus;
    }

    public function index()
    {
        try {
            $reports = $this->getAllReports->execute();
            return response()->json(['reports' => $reports], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByPriority($priority)
    {
        try {
            $reports = $this->getReportsByPriority->execute($priority);
            return response()->json(['reports' => $reports], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByStatus($status)
    {
        try {
            $reports = $this->getReportsByStatus->execute($status);
            return response()->json(['reports' => $reports], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByBuildingId($buildingID)
    {
        try {
            $reports = $this->getReportsByBuildingId->execute($buildingID);
            return response()->json(['reports' => $reports], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'buildingID' => 'required|exists:buildings,buildingID',
                'roomID' => 'required|exists:rooms,roomID',
                'categoryID' => 'required|exists:categories,categoryID',
                'goodID' => 'required|exists:goods,goodID',
                'priority' => 'required|in:Immediate,Normal',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Validar imagen
                'id' => 'required|exists:users,id',
                'status' => 'required|in:Enviado,Diagnosticado,En Proceso,Terminado', // Actualizar validación
                'requires_approval' => 'required|boolean',
                'involve_third_parties' => 'required|boolean',
            ]);
    
            $data = $request->all();
    
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('reports', 'public');
                $data['image'] = Storage::url($path);
            }

            $report = $this->createReport->execute($data);
    
            return response()->json(['report' => $report], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOrderedByDate($order)
    {
        try {
            $reports = $this->getReportsOrderedByDate->execute($order);
            return response()->json(['reports' => $reports], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByFolio($folio)
    {
        try {
            $report = $this->getReportByFolio->execute($folio);
            return response()->json(['report' => $report], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $reportID)
    {
        try {
            $request->validate([
                'buildingID' => 'required|exists:buildings,buildingID',
                'roomID' => 'required|exists:rooms,roomID',
                'categoryID' => 'required|exists:categories,categoryID',
                'goodID' => 'required|exists:goods,goodID',
                'priority' => 'required|in:Immediate,Normal',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Validar imagen
                'id' => 'required|exists:users,id',
                'status' => 'required|in:Enviado,Diagnosticado,En Proceso,Terminado', // Actualizar validación
                'requires_approval' => 'required|boolean',
                'involve_third_parties' => 'required|boolean',
            ]);

            $data = $request->all();

            // Obtener el reporte existente
            $existingReport = $this->getReportByFolio->execute($reportID);

            if ($request->hasFile('image')) {
                // Eliminar la imagen antigua si existe
                if ($existingReport && $existingReport->image) {
                    $oldImagePath = str_replace('/storage', 'public', $existingReport->image);
                    Storage::delete($oldImagePath);
                }

                // Guardar la nueva imagen
                $path = $request->file('image')->store('reports', 'public');
                $data['image'] = Storage::url($path);
            }

            $report = $this->updateReport->execute($reportID, $data);

            return response()->json(['report' => $report], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $reportID)
    {
        try {
            $request->validate([
                'status' => 'required|in:Enviado,Diagnosticado,En Proceso,Terminado', // Actualizar validación
            ]);

            $status = $request->input('status');
            $report = $this->updateReportStatus->execute($reportID, $status);

            return response()->json(['report' => $report], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
