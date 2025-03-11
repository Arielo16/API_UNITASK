<?php

namespace App\Core\Reports\Repositories;

use App\Core\Reports\Entities\ReportEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReportRepositoryInterface
{
    public function getAll($perPage = 15): LengthAwarePaginator;
    public function getByPriority(string $priority, $perPage = 15): LengthAwarePaginator;
    public function getByStatus(string $status, $perPage = 15): LengthAwarePaginator;
    public function create(array $data): ReportEntity;
    public function getNextId(): int;
    public function getByBuildingId($buildingID, $perPage = 15): LengthAwarePaginator;
    public function getOrderedByDate(string $order, $perPage = 15): LengthAwarePaginator;
    public function getByFolio($folio): ?ReportEntity;
    public function update($reportID, array $data): ReportEntity;
    public function updateStatus($reportID, string $status): ReportEntity;
    public function getById($reportID): ?ReportEntity;
}
