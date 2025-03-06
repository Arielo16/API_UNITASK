<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Core\Diagnostics\UseCases\CreateDiagnostic;
use App\Core\Diagnostics\UseCases\GetDiagnosticByReportID;
use App\Core\Diagnostics\UseCases\UpdateDiagnosticStatus;
use App\Core\Diagnostics\UseCases\GetDiagnosticsByStatus;
use App\Core\Diagnostics\UseCases\GetDiagnosticsOrderedByDate;
use Exception;
use Illuminate\Support\Facades\Storage;

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
        try {
            $validatedData = $request->validate([
                'reportID' => 'required|exists:reports,reportID',
                'description' => 'required|string',
                'images' => 'nullable|file|mimes:png,jpeg,jpg', // Validar como archivo .png, .jpeg, .jpg
                'status' => 'required|in:Enviado,Para Reparar,En Proceso,Terminado',
                'materialID' => 'nullable|integer|exists:materials,materialID', // Validar materialID
            ]);

            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $path = $image->store('diagnostics', 'public'); // Guardar la imagen en storage/diagnostics
                $validatedData['images'] = $path; // Guardar el path de la imagen
            } else {
                $validatedData['images'] = null; // Asignar null si no se proporciona una imagen
            }

            $diagnosticID = DB::table('diagnostics')->insertGetId([
                'reportID' => $validatedData['reportID'],
                'description' => $validatedData['description'],
                'images' => $validatedData['images'],
                'status' => $validatedData['status'],
                'materialID' => $validatedData['materialID'] ?? null, // Asignar materialID si se proporciona
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Actualizar el estado del reporte a "Diagnosticado"
            $report = Report::findOrFail($validatedData['reportID']);
            $report->status = 'Diagnosticado';
            $report->save();

            return response()->json(['diagnosticID' => $diagnosticID], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            ]);

            $status = $request->input('status');
            $diagnostic = $this->updateDiagnosticStatus->execute($reportID, $status);

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
