<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use App\Core\Reports\Entities\ReportEntity;
use Exception;

class UpdateReportStatus
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($reportID, string $status): ReportEntity
    {
        try {
            return $this->reportRepository->updateStatus($reportID, $status);
        } catch (Exception $e) {
            throw new Exception('Error updating report status: ' . $e->getMessage());
        }
    }
}
