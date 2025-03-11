<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetReportsOrderedByDate
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(string $order, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->reportRepository->getOrderedByDate($order, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching reports ordered by date: ' . $e->getMessage());
        }
    }
}
