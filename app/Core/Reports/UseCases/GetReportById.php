<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;

class GetReportById
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($reportID)
    {
        try {
            return $this->reportRepository->getById($reportID);
        } catch (Exception $e) {
            throw new Exception('Error fetching report by ID: ' . $e->getMessage());
        }
    }
}
