<?php

namespace App\Core\Reports\Repositories;

use App\Core\Reports\Entities\ReportEntity;

interface ReportRepositoryInterface
{
    public function getAll(): array;
    public function getByPriority(string $priority): array;
    public function getByStatus(string $status): array;
    public function getByBuildingId($buildingID): array;
    public function getOrderedByDate($order): array;
}
