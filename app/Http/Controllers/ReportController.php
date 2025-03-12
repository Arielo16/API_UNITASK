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
use App\Core\Reports\UseCases\CheckReportStatus;
use App\Core\Reports\UseCases\GetReportById; 
use Exception;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class ReportController extends Controller
{
    private const PER_PAGE = 15;

    private $getAllReports;
    private $getReportsByPriority;
    private $getReportsByStatus;
    private $createReport;
    private $getReportsByBuildingId;
    private $getReportsOrderedByDate;
    private $getReportByFolio;
    private $updateReport;
    private $updateReportStatus;
    private $checkReportStatus;
    private $getReportById;

    public function __construct(
        GetAllReports $getAllReports, 
        GetReportsByPriority $getReportsByPriority, 
        GetReportsByStatus $getReportsByStatus, 
        CreateReport $createReport,
        GetReportsByBuildingId $getReportsByBuildingId,
        GetReportsOrderedByDate $getReportsOrderedByDate,
        GetReportByFolio $getReportByFolio,
        UpdateReport $updateReport,
        UpdateReportStatus $updateReportStatus,
        CheckReportStatus $checkReportStatus,
        GetReportById $getReportById 
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
        $this->checkReportStatus = $checkReportStatus;
        $this->getReportById = $getReportById; 
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', self::PER_PAGE); 
            $reports = $this->getAllReports->execute($perPage);
            $reportsArray = $reports->items();
            $reportsArray = array_map(function ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
                return $reportArray;
            }, $reportsArray);
            return response()->json(['pagination' => $reports->toArray()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByPriority(Request $request, $priority)
    {
        try {
            $perPage = $request->query('per_page', self::PER_PAGE);
            $reports = $this->getReportsByPriority->execute($priority, $perPage);
            $reportsArray = $reports->items(); 
            $reportsArray = array_map(function ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
                return $reportArray;
            }, $reportsArray);
            return response()->json(['pagination' => $reports->toArray()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByStatus(Request $request, $status)
    {
        try {
            $perPage = $request->query('per_page', self::PER_PAGE);
            $reports = $this->getReportsByStatus->execute($status, $perPage);
            $reportsArray = $reports->items(); 
            $reportsArray = array_map(function ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
                return $reportArray;
            }, $reportsArray);
            return response()->json(['pagination' => $reports->toArray()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByBuildingId(Request $request, $buildingID)
    {
        try {
            $perPage = $request->query('per_page', self::PER_PAGE); 
            $reports = $this->getReportsByBuildingId->execute($buildingID, $perPage);
            $reportsArray = $reports->items(); 
            $reportsArray = array_map(function ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
                return $reportArray;
            }, $reportsArray);
            return response()->json(['pagination' => $reports->toArray()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        $path = null;
        try {
            $request->validate([
                'buildingID' => 'required|exists:buildings,buildingID',
                'roomID' => 'required|exists:rooms,roomID',
                'categoryID' => 'required|exists:categories,categoryID',
                'goodID' => 'required|exists:goods,goodID',
                'priority' => 'required|in:Immediate,Normal',
                'description' => 'required|string',
                'image' => 'nullable|file|mimes:png,jpeg,jpg',
                'userID' => 'required|exists:users,id',
                'status' => 'required|in:Enviado,Diagnosticado,En Proceso,Terminado', 
                'requires_approval' => 'required|boolean',
                'involve_third_parties' => 'required|boolean',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')) {
                Configuration::instance(getenv('CLOUDINARY_URL'));

                $uploadedFile = (new UploadApi())->upload($request->file('image')->getRealPath());
                $data['image'] = $uploadedFile['secure_url']; 
            } else {
                $data['image'] = null;
            }

            $nextId = $this->createReport->getNextId();
            $data['folio'] = 'REP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $data['id'] = $request->input('userID');

            $report = $this->createReport->execute($data);

            return response()->json(['report' => $report], 201);
        } catch (Exception $e) {
            if ($path) {
                Storage::disk('public')->delete($path); 
            }
            return response()->json(['error' => 'Error creating report: ' . $e->getMessage()], 500);
        }
    }

    public function getOrderedByDate(Request $request, $order)
    {
        try {
            $perPage = $request->query('per_page', self::PER_PAGE); 
            $reports = $this->getReportsOrderedByDate->execute($order, $perPage);
            $reportsArray = $reports->items(); 
            $reportsArray = array_map(function ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
                return $reportArray;
            }, $reportsArray);
            return response()->json(['pagination' => $reports->toArray()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByFolio($folio)
    {
        try {
            $report = $this->getReportByFolio->execute($folio);
            if ($report) {
                $reportArray = (array) $report;
                $reportArray['userID'] = $reportArray['id'];
                unset($reportArray['id']);
            }
            return response()->json(['report' => $reportArray], 200);
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
                'image' => 'nullable|file|mimes:png,jpeg,jpg', 
                'userID' => 'required|exists:users,id',
                'status' => 'required|in:Enviado,Diagnosticado,En Proceso,Terminado', 
                'requires_approval' => 'required|boolean',
                'involve_third_parties' => 'required|boolean',
            ]);

            $data = $request->except('image'); 

            $existingReport = $this->getReportById->execute($reportID);

            if (!$existingReport) {
                return response()->json(['error' => 'Report not found'], 404);
            }

            if ($request->hasFile('image')) {
                Configuration::instance(getenv('CLOUDINARY_URL'));

                $uploadedFile = (new UploadApi())->upload($request->file('image')->getRealPath());
                $data['image'] = $uploadedFile['secure_url']; 
            } else {
                $data['image'] = $existingReport->image;
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

    public function checkStatus($reportID)
    {
        try {
            $status = $this->checkReportStatus->execute($reportID);
            return response()->json(['status' => $status], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
