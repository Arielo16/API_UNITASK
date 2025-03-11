<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GetDiagnosticsOrderedByDate
{
    private $diagnosticRepository;

    public function __construct(DiagnosticRepositoryInterface $diagnosticRepository)
    {
        $this->diagnosticRepository = $diagnosticRepository;
    }

    public function execute(string $order, $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->diagnosticRepository->getOrderedByDate($order, $perPage);
        } catch (Exception $e) {
            throw new Exception('Error fetching diagnostics ordered by date: ' . $e->getMessage());
        }
    }
}
