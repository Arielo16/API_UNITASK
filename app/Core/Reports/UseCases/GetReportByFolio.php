<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use App\Core\Reports\Entities\ReportEntity;
use Exception;

class GetReportByFolio
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($folio): ?ReportEntity
    {
        try {
            return $this->reportRepository->getByFolio($folio);
        } catch (Exception $e) {
            throw new Exception('Error fetching report by folio: ' . $e->getMessage());
        }
    }
}
