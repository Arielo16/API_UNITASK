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
            $material = $data['materialID'] ? Material::find($data['materialID']) : null;
            return new DiagnosticEntity(
                $diagnostic->diagnosticID,
                $diagnostic->reportID,
                $diagnostic->description,
                $diagnostic->images,
                $diagnostic->status,
                Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'), 
                Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                $material ? [$material->toArray()] : [] // Incluir material si existe
            );
        } catch (Exception $e) {
            throw new Exception('Error creating diagnostic: ' . $e->getMessage());
        }
    }

    public function getByReportID($reportID): ?DiagnosticEntity
    {
        try {
            $diagnostic = Diagnostic::where('reportID', $reportID)->first();
            if ($diagnostic) {
                $material = $diagnostic->materialID ? Material::find($diagnostic->materialID) : null;
                return new DiagnosticEntity(
                    $diagnostic->diagnosticID,
                    $diagnostic->reportID,
                    $diagnostic->description,
                    $diagnostic->images,
                    $diagnostic->status,
                    Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'),
                    Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                    $material ? [$material->toArray()] : [] // Incluir material si existe
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
            $material = $diagnostic->materialID ? Material::find($diagnostic->materialID) : null;
            return new DiagnosticEntity(
                $diagnostic->diagnosticID,
                $diagnostic->reportID,
                $diagnostic->description,
                $diagnostic->images,
                $diagnostic->status,
                Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'),
                Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                $material ? [$material->toArray()] : [] // Incluir material si existe
            );
        } catch (Exception $e) {
            throw new Exception('Error updating diagnostic status: ' . $e->getMessage());
        }
    }

    public function updateMaterialIDs($reportID, array $materialIDs): DiagnosticEntity
    {
        try {
            $diagnostic = Diagnostic::where('reportID', $reportID)->firstOrFail();
            $diagnostic->materialIDs = json_encode($materialIDs); // Convertir a JSON
            $diagnostic->save();
            $materials = Material::whereIn('materialID', $materialIDs)->get(['materialID', 'name', 'supplier', 'quantity', 'price'])->toArray();

            return new DiagnosticEntity(
                $diagnostic->diagnosticID,
                $diagnostic->reportID,
                $diagnostic->description,
                $diagnostic->images,
                $diagnostic->status,
                Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'),
                Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                $materials // Incluir materiales sin created_at y updated_at
            );
        } catch (Exception $e) {
            throw new Exception('Error updating material IDs: ' . $e->getMessage());
        }
    }

    public function getByStatus(string $status): array
    {
        try {
            $diagnostics = Diagnostic::where('status', $status)->get();
            return $diagnostics->map(function ($diagnostic) {
                $material = $diagnostic->materialID ? Material::find($diagnostic->materialID) : null;
                return new DiagnosticEntity(
                    $diagnostic->diagnosticID,
                    $diagnostic->reportID,
                    $diagnostic->description,
                    $diagnostic->images,
                    $diagnostic->status,
                    Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'),
                    Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                    $material ? [$material->toArray()] : [] // Incluir material si existe
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics by status: ' . $e->getMessage());
        }
    }

    public function getOrderedByDate(string $order): array
    {
        try {
            $diagnostics = Diagnostic::orderBy('created_at', $order)->get();
            return $diagnostics->map(function ($diagnostic) {
                $material = $diagnostic->materialID ? Material::find($diagnostic->materialID) : null;
                return new DiagnosticEntity(
                    $diagnostic->diagnosticID,
                    $diagnostic->reportID,
                    $diagnostic->description,
                    $diagnostic->images,
                    $diagnostic->status,
                    Carbon::parse($diagnostic->created_at)->format('Y-m-d H:i'),
                    Carbon::parse($diagnostic->updated_at)->format('Y-m-d H:i'),
                    $material ? [$material->toArray()] : [] // Incluir material si existe
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics ordered by date: ' . $e->getMessage());
        }
    }
}
