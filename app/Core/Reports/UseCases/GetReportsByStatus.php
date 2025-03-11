<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetReportsByStatus
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(string $status, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->reportRepository->getByStatus($status, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by status: ' . $e->getMessage());
        }
    }
}
