<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Diagnostics\UseCases\CreateDiagnostic;
use App\Core\Diagnostics\UseCases\GetDiagnosticByReportID;
use App\Core\Diagnostics\UseCases\UpdateDiagnosticStatus;
use Exception;

class DiagnosticController extends Controller
{
    private $createDiagnostic;
    private $getDiagnosticByReportID;
    private $updateDiagnosticStatus;

    public function __construct(
        CreateDiagnostic $createDiagnostic,
        GetDiagnosticByReportID $getDiagnosticByReportID,
        UpdateDiagnosticStatus $updateDiagnosticStatus
    ) {
        $this->createDiagnostic = $createDiagnostic;
        $this->getDiagnosticByReportID = $getDiagnosticByReportID;
        $this->updateDiagnosticStatus = $updateDiagnosticStatus;
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'reportID' => 'required|exists:reports,reportID',
                'description' => 'required|string',
                'images' => 'nullable|string', // Permitir valores nulos
                'status' => 'required|in:Enviado,Para Reparar,En Proceso,Terminado',
                'materials' => 'nullable|array',
                'materials.*.name' => 'required_with:materials|string',
                'materials.*.supplier' => 'required_with:materials|string',
                'materials.*.quantity' => 'required_with:materials|integer',
                'materials.*.price' => 'required_with:materials|numeric',
            ]);

            $data = $request->all();
            if (empty($data['images'])) {
                $data['images'] = null; // Asignar null si no se proporciona una imagen
            }

            // Validar que no exista otro diagnóstico con el mismo reportID
            $existingDiagnostic = $this->getDiagnosticByReportID->execute($data['reportID']);
            if ($existingDiagnostic) {
                return response()->json(['error' => 'A diagnostic already exists for this report ID'], 400);
            }

            $diagnostic = $this->createDiagnostic->execute($data);

            return response()->json(['diagnostic' => $diagnostic], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByReportID($reportID)
    {
        try {
            $diagnostic = $this->getDiagnosticByReportID->execute($reportID);
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
}
