<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use App\Core\Reports\Entities\ReportEntity;
use Exception;

class UpdateReport
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($reportID, array $data): ReportEntity
    {
        try {
            return $this->reportRepository->update($reportID, $data);
        } catch (Exception $e) {
            throw new Exception('Error updating report: ' . $e->getMessage());
        }
    }
}
