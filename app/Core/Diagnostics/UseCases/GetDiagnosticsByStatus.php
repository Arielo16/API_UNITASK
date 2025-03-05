<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use Exception;

class GetDiagnosticsByStatus
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute(string $status): array
    {
        try {
            return $this->diagnosticRepository->getByStatus($status);
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics by status: ' . $e->getMessage());
        }
    }
}
