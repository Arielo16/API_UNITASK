<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use Exception;

class GetDiagnosticsOrderedByDate
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute(string $order): array
    {
        try {
            return $this->diagnosticRepository->getOrderedByDate($order);
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics ordered by date: ' . $e->getMessage());
        }
    }
}
