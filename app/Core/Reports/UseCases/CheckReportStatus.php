<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;

class CheckReportStatus
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute($reportID): bool
    {
        $report = $this->reportRepository->getById($reportID);
        if (in_array($report->status, ['Diagnosticado', 'En Proceso', 'Terminado'])) {
            return false;
        } elseif ($report->status === 'Enviado') {
            $this->reportRepository->updateStatus($reportID, 'Diagnosticado');
            return true;
        }
        return false;
    }
}
