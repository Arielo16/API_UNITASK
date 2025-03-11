<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllReports
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->reportRepository->getAll($perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching all reports: ' . $e->getMessage());
        }
    }
}
