<?php

namespace App\Core\Diagnostics\Repositories;

use App\Core\Diagnostics\Entities\DiagnosticEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface DiagnosticRepositoryInterface
{
    public function create(array $data): DiagnosticEntity;
    public function getByReportID($reportID): ?DiagnosticEntity;
    public function updateStatus($reportID, string $status): DiagnosticEntity;
    public function getByStatus(string $status, $perPage = 15): LengthAwarePaginator;
    public function getOrderedByDate(string $order, $perPage = 15): LengthAwarePaginator;
}
