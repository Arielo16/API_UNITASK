<?php

namespace App\Infrastructure\Persistence;

use App\Models\Report;
use App\Core\Reports\Entities\ReportEntity;
use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAll($perPage = 15): LengthAwarePaginator
    {
        try {
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->paginate($perPage);
            $reports->getCollection()->transform(function ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            });
            return $reports;
        } catch (Exception $e) {
            throw new Exception('Error fetching reports: ' . $e->getMessage());
        }
    }

    public function getByPriority(string $priority, $perPage = 15): LengthAwarePaginator
    {
        try {
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->where('priority', $priority)->paginate($perPage);
            $reports->getCollection()->transform(function ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            });
            return $reports;
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by priority: ' . $e->getMessage());
        }
    }

    public function getByStatus(string $status, $perPage = 15): LengthAwarePaginator
    {
        try {
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])->where('status', $status)->paginate($perPage);
            $reports->getCollection()->transform(function ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            });
            return $reports;
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
                $report->goodID, 
                $report->priority,
                $report->description,
                $report->image,
                $report->id, // Cambiar a id
                $report->status,
                $report->requires_approval,
                $report->involve_third_parties,
                Carbon::parse($report->created_at)->format('Y-m-d H:i')
            );
        } catch (Exception $e) {
            throw new Exception('Error creating report: ' . $e->getMessage());
        }
    }

    public function getNextId(): int
    {
        return Report::max('reportID') + 1;
    }

    public function getByBuildingId($buildingID, $perPage = 15): LengthAwarePaginator
    {
        try {
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])
                ->where('buildingID', $buildingID)
                ->paginate($perPage);
            $reports->getCollection()->transform(function ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            });
            return $reports;
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by building ID: ' . $e->getMessage());
        }
    }

    public function getOrderedByDate(string $order, $perPage = 15): LengthAwarePaginator
    {
        try {
            $reports = Report::with(['room', 'good', 'building', 'category', 'user'])
                ->orderBy('created_at', $order)
                ->paginate($perPage);
            $reports->getCollection()->transform(function ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            });
            return $reports;
        } catch (Exception $e) {
            throw new Exception('Error fetching reports ordered by date: ' . $e->getMessage());
        }
    }

    public function getByFolio($folio): ?ReportEntity
    {
        try {
            $report = Report::with(['room', 'good', 'building', 'category', 'user'])
                ->where('folio', $folio)
                ->first();
            if ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Error fetching report by folio: ' . $e->getMessage());
        }
    }

    public function update($reportID, array $data): ReportEntity
    {
        try {
            $report = Report::findOrFail($reportID);
            $report->update($data);
            return new ReportEntity(
                $report->reportID,
                $report->folio,
                $report->buildingID, 
                $report->roomID, 
                $report->categoryID, 
                $report->goodID, 
                $report->priority,
                $report->description,
                $report->image,
                $report->id, // Cambiar a id
                $report->status,
                $report->requires_approval,
                $report->involve_third_parties,
                Carbon::parse($report->created_at)->format('Y-m-d H:i')
            );
        } catch (Exception $e) {
            throw new Exception('Error updating report: ' . $e->getMessage());
        }
    }

    public function updateStatus($reportID, string $status): ReportEntity
    {
        try {
            $report = Report::findOrFail($reportID);
            $report->status = $status;
            $report->save();
            return new ReportEntity(
                $report->reportID,
                $report->folio,
                $report->buildingID, 
                $report->roomID, 
                $report->categoryID, 
                $report->goodID, 
                $report->priority,
                $report->description,
                $report->image,
                $report->id, // Cambiar a id
                $report->status,
                $report->requires_approval,
                $report->involve_third_parties,
                Carbon::parse($report->created_at)->format('Y-m-d H:i')
            );
        } catch (Exception $e) {
            throw new Exception('Error updating report status: ' . $e->getMessage());
        }
    }

    public function getById($reportID): ?ReportEntity
    {
        try {
            $report = Report::with(['room', 'good', 'building', 'category', 'user'])->find($reportID);
            if ($report) {
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
                    $report->user ? $report->user->username : null, // Manejar el caso en que user sea null
                    $report->status,
                    $report->requires_approval,
                    $report->involve_third_parties,
                    Carbon::parse($report->created_at)->format('Y-m-d H:i'),
                    $report->user ? $report->user->id : null // Manejar el caso en que user sea null
                );
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Error fetching report by ID: ' . $e->getMessage());
        }
    }
}
