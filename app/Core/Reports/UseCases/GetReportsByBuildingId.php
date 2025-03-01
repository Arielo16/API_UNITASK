<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;

class GetReportsByBuildingId
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($buildingID): array
    {
        try {
            return $this->reportRepository->getByBuildingId($buildingID);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports by building ID: ' . $e->getMessage());
        }
    }
}
