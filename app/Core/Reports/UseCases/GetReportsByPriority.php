<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetReportsByPriority
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(string $priority, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->reportRepository->getByPriority($priority, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by priority: ' . $e->getMessage());
        }
    }
}
