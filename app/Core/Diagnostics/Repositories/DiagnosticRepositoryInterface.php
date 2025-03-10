<?php

namespace App\Core\Diagnostics\Repositories;

use App\Core\Diagnostics\Entities\DiagnosticEntity;

interface DiagnosticRepositoryInterface
{
    public function create(array $data): DiagnosticEntity;
    public function getByReportID($reportID): ?DiagnosticEntity;
    public function updateStatus($reportID, string $status): DiagnosticEntity;
    public function getByStatus(string $status): array;
    public function getOrderedByDate(string $order): array;
}
