<?php

namespace App\Core\Diagnostics\UseCases;

use App\Core\Diagnostics\Repositories\DiagnosticRepositoryInterface;
use App\Core\Diagnostics\Entities\DiagnosticEntity;
use App\Core\Materials\Repositories\MaterialRepositoryInterface;
use Exception;

class CreateDiagnostic
{
    private $diagnosticRepository;
    private $materialRepository;

    public function __construct(
        DiagnosticRepositoryInterface $diagnosticRepository,
        MaterialRepositoryInterface $materialRepository
    ) {
        $this->diagnosticRepository = $diagnosticRepository;
        $this->materialRepository = $materialRepository;
    }

    public function execute(array $data): DiagnosticEntity
    {
        try {
            $diagnostic = $this->diagnosticRepository->create($data);

            if (!empty($data['materialIDs'])) {
                foreach ($data['materialIDs'] as $materialID) {
                    $material = $this->materialRepository->find($materialID);
                    if ($material) {
                        // Realizar alguna acción con el material si es necesario
                    }
                }
            }

            return $diagnostic;
        } catch (Exception $e) {
            throw new Exception('Error creating diagnostic: ' . $e->getMessage());
        }
    }
}
