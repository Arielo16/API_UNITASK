<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use App\Core\Diagnostics\Entities\DiagnosticEntity;
use Exception;

class UpdateDiagnosticStatus
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute($reportID, string $status): DiagnosticEntity
    {
        try {
            return $this->diagnosticRepository->updateStatus($reportID, $status);
        } catch (Exception $e) {
            throw new Exception('Error updating diagnostic status: ' . $e->getMessage());
        }
    }
}
