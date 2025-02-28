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
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->building->name, 
                    $report->room->name, 
                    $report->category->name, 
                    $report->good->name, 
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->user->username, 
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
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->where('priority', $priority)->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->building->name, 
                    $report->room->name, 
                    $report->category->name, 
                    $report->good->name, 
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->user->username, 
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
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->where('status', $status)->get();
            return $reports->map(function ($report) {
                return new ReportEntity(
                    $report->reportID,
                    $report->folio,
                    $report->building->name, 
                    $report->room->name,
                    $report->category->name, 
                    $report->good->name,
                    $report->priority,
                    $report->description,
                    $report->image,
                    $report->user->username, 
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties
                );
            })->toArray();
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by status: ' . $e->getMessage());
        }
    }

    public function create(array $data): ReportEntity
    {
        try {
            $report = Report::create($data);
            return new ReportEntity(
                $report->reportID,
                $report->folio,
                $report->buildingID, 
                $report->roomID, 
                $report->categoryID,
                $report->good->name,
                $report->priority,
                $report->description,
                $report->image,
                $report->id, 
                $report->status,
                $report->requires_approval,
                $report->involve_third_parties
            );
        } catch (Exception $e) {
            throw new Exception('Error creating report: ' . $e->getMessage());
        }
    }

    public function getNextId(): int
    {
        return Report::max('reportID') + 1;
    }
}
