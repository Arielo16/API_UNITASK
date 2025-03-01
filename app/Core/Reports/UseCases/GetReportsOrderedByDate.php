<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;

class GetReportsOrderedByDate
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($order): array
    {
        try {
            return $this->reportRepository->getOrderedByDate($order);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports ordered by date: ' . $e->getMessage());
        }
    }
}
