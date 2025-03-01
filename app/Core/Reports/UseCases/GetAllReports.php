<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;

class GetAllReports
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(): array
    {
        try {
            return $this->reportRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error fetching all reports: ' . $e->getMessage());
        }
    }
}
