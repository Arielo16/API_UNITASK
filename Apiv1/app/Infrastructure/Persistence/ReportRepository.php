<?php

namespace App\Infrastructure\Persistence;

use App\Models\Report;
use App\Core\Reports\Entities\ReportEntity;
use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAll(): array
    {
        try {
            $reports = Report::with('room')->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->buildingID,
                    $report->room->name, // Obtener el nombre de la habitación
                    $report->categoryID,
                    $report->goodID,
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->id,
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching reports: ' . $e->getMessage());
        }
    }

    public function getByPriority(string $priority): array
    {
        try {
            $reports = Report::with('room')->where('priority', $priority)->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->buildingID,
                    $report->room->name, // Obtener el nombre de la habitación
                    $report->categoryID,
                    $report->goodID,
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->id,
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by priority: ' . $e->getMessage());
        }
    }

    public function getByStatus(string $status): array
    {
        try {
            $reports = Report::with('room')->where('status', $status)->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->buildingID,
                    $report->room->name, // Obtener el nombre de la habitación
                    $report->categoryID,
                    $report->goodID,
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->id,
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by status: ' . $e->getMessage());
        }
    }
}
