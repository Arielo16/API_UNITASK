<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\Diagnostic; // Importar la clase Diagnostic
use App\Core\Diagnostics\UseCases\CreateDiagnostic;
use App\Core\Diagnostics\UseCases\GetDiagnosticByReportID;
use App\Core\Diagnostics\UseCases\UpdateDiagnosticStatus;
use App\Core\Diagnostics\UseCases\GetDiagnosticsByStatus;
use App\Core\Diagnostics\UseCases\GetDiagnosticsOrderedByDate;
use Exception;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class DiagnosticController extends Controller
{
    private $createDiagnostic;
    private $getDiagnosticByReportID;
    private $updateDiagnosticStatus;
    private $getDiagnosticsByStatus;
    private $getDiagnosticsOrderedByDate;

    public function __construct(
        CreateDiagnostic $createDiagnostic,
        GetDiagnosticByReportID $getDiagnosticByReportID,
        UpdateDiagnosticStatus $updateDiagnosticStatus,
        GetDiagnosticsByStatus $getDiagnosticsByStatus,
        GetDiagnosticsOrderedByDate $getDiagnosticsOrderedByDate
    ) {
        $this->createDiagnostic = $createDiagnostic;
        $this->getDiagnosticByReportID = $getDiagnosticByReportID;
        $this->updateDiagnosticStatus = $updateDiagnosticStatus;
        $this->getDiagnosticsByStatus = $getDiagnosticsByStatus;
        $this->getDiagnosticsOrderedByDate = $getDiagnosticsOrderedByDate;
    }

    public function create(Request $request)
    {
        $path = null;
        try {
            $request->validate([
                'reportID' => 'required|exists:reports,reportID',
                'description' => 'required|string',
                'images' => 'nullable|file|mimes:png,jpeg,jpg',
                'status' => 'required|in:Enviado,Para Reparar,En Proceso,Terminado',
                'materials' => 'array',
                'materials.*' => 'integer|exists:materials,materialID',
            ]);

            $data = $request->all();

            if ($request->hasFile('images')) {
                Configuration::instance(getenv('CLOUDINARY_URL'));

                $uploadedFile = (new UploadApi())->upload($request->file('images')->getRealPath());
                $data['images'] = $uploadedFile['secure_url'];
            } else {
                $data['images'] = null;
            }

            $existingDiagnostic = $this->getDiagnosticByReportID->execute($data['reportID']);
            if ($existingDiagnostic) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
                return response()->json(['error' => 'A diagnostic already exists for this report ID'], 400);
            }

            $diagnostic = $this->createDiagnostic->execute($data);

            // Sincronizar materiales en el modelo Diagnostic
            $diagnosticModel = Diagnostic::find($diagnostic->diagnosticID);
            if (isset($data['materials'])) {
                $diagnosticModel->materials()->sync($data['materials']);
            }

            $report = Report::findOrFail($data['reportID']);
            $report->status = 'Diagnosticado';
            $report->save();

            return response()->json(['diagnostic' => $diagnostic], 201);
        } catch (Exception $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            return response()->json(['error' => 'Error creating diagnostic: ' . $e->getMessage()], 500);
        }
    }

    public function getByReportID($reportID)
    {
        try {
            $diagnostic = $this->getDiagnosticByReportID->execute($reportID);
            if ($diagnostic && $diagnostic->images) {
                $diagnostic->images = Storage::disk('public')->url($diagnostic->images);
            }
            return response()->json(['diagnostic' => $diagnostic], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $reportID)
    {
        try {
            $request->validate([
                'status' => 'required|in:Enviado,Para Reparar,En Proceso,Terminado',
                'images' => 'nullable|file|mimes:png,jpeg,jpg',
                'materials' => 'array',
                'materials.*' => 'integer|exists:materials,materialID',
            ]);

            $data = $request->all();

            if ($request->hasFile('images')) {
                Configuration::instance(getenv('CLOUDINARY_URL'));

                $uploadedFile = (new UploadApi())->upload($request->file('images')->getRealPath());
                $data['images'] = $uploadedFile['secure_url'];
            }

            $diagnostic = $this->updateDiagnosticStatus->execute($reportID, $data);

            if (isset($data['materials'])) {
                $diagnostic->materials()->sync($data['materials']);
            }

            return response()->json(['diagnostic' => $diagnostic], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByStatus($status)
    {
        try {
            $diagnostics = $this->getDiagnosticsByStatus->execute($status);
            foreach ($diagnostics as $diagnostic) {
                if ($diagnostic->images) {
                    $diagnostic->images = Storage::disk('public')->url($diagnostic->images);
                }
            }
            return response()->json(['diagnostics' => $diagnostics], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOrderedByDate($order)
    {
        try {
            $diagnostics = $this->getDiagnosticsOrderedByDate->execute($order);
            foreach ($diagnostics as $diagnostic) {
                if ($diagnostic->images) {
                    $diagnostic->images = Storage::disk('public')->url($diagnostic->images);
                }
            }
            return response()->json(['diagnostics' => $diagnostics], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
