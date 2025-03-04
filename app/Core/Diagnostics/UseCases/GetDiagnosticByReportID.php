<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use App\Core\Diagnostics\Entities\DiagnosticEntity;
use Exception;

class GetDiagnosticByReportID
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute($reportID): ?DiagnosticEntity
    {
        try {
            return $this->diagnosticRepository->getByReportID($reportID);
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostic by report ID: ' . $e->getMessage());
        }
    }
}
