<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetReportsByBuildingId
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($buildingID, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->reportRepository->getByBuildingId($buildingID, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by building ID: ' . $e->getMessage());
        }
    }
}
