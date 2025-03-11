<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetDiagnosticsByStatus
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute(string $status, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->diagnosticRepository->getByStatus($status, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics by status: ' . $e->getMessage());
        }
    }
}
