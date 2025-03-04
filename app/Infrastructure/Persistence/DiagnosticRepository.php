<?php

namespace App\Infrastructure\Persistence;

use App\Models\Diagnostic;
use App\Models\Material;
use App\Core\Diagnostics\Entities\DiagnosticEntity;
use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use Exception;
use Carbon\Carbon;

class DiagnosticRepository implements DiagnosticRepositoryInterface
{
    public function create(array $data): DiagnosticEntity
    {
        try {
            if (empty($data['images'])) {
                $data['images'] = null; 
            }
            $diagnostic = Diagnostic::create($data);
            return new DiagnosticEntity(
                $diagnostic->diagnosticID,
                $diagnostic->reportID,
                $diagnostic->description,
                $diagnostic->images,
                $diagnostic->status,
                Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'), 
                $diagnostic->updated_at 
            );
        } catch (Exception $e) {
            throw new Exception('Error creating diagnostic: ' . $e->getMessage());
        }
    }

    public function getByReportID($reportID): ?DiagnosticEntity
    {
        try {
            $diagnostic = Diagnostic::where('reportID', $reportID)->with('materials')->first();
            if ($diagnostic) {
                $materials = $diagnostic->materials->map(function ($material) {
                    return [
                        'materialID' => $material->materialID,
                        'name' => $material->name,
                        'supplier' => $material->supplier,
                        'quantity' => $material->quantity,
                        'price' => $material->price,
                    ];
                });

                return new DiagnosticEntity(
                    $diagnostic->diagnosticID,
                    $diagnostic->reportID,
                    $diagnostic->description,
                    $diagnostic->images,
                    $diagnostic->status,
                    Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'), // Formatear created_at
                    Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'), // Formatear updated_at
                    $materials->toArray() // Incluir materiales
                );
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostic by report ID: ' . $e->getMessage());
        }
    }

    public function updateStatus($reportID, string $status): DiagnosticEntity
    {
        try {
            $diagnostic = Diagnostic::where('reportID', $reportID)->firstOrFail();
            $diagnostic->status = $status;
            $diagnostic->save();
            return new DiagnosticEntity(
                $diagnostic->diagnosticID,
                $diagnostic->reportID,
                $diagnostic->description,
                $diagnostic->images,
                $diagnostic->status,
                Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'), // Formatear created_at
                Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i') // Formatear updated_at
            );
        } catch (Exception $e) {
            throw new Exception('Error updating diagnostic status: ' . $e->getMessage());
        }
    }
}
