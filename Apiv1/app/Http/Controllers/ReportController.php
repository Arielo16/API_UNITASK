<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Reports\UseCases\GetAllReports;
use App\Core\Reports\UseCases\GetReportsByPriority;
use App\Core\Reports\UseCases\GetReportsByStatus;
use App\Core\Reports\UseCases\CreateReport;
use Exception;

class ReportController extends Controller
{
    private $getAllReports;
    private $getReportsByPriority;
    private $getReportsByStatus;
    private $createReport;

    public function __construct(GetAllReports $getAllReports, GetReportsByPriority $getReportsByPriority, GetReportsByStatus $getReportsByStatus, CreateReport $createReport)
    {
        $this->getAllReports = $getAllReports;
        $this->getReportsByPriority = $getReportsByPriority;
        $this->getReportsByStatus = $getReportsByStatus;
        $this->createReport = $createReport;
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
                'image' => 'nullable|string',
                'id' => 'required|exists:users,id',
                'status' => 'required|in:Enviado,Diagnosticado,EnProceso,Terminado',
                'requires_approval' => 'required|boolean',
                'involve_third_parties' => 'required|boolean',
            ]);

            $report = $this->createReport->execute($request->all());

            return response()->json(['report' => $report], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
