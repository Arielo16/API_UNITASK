<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use App\Core\Reports\Entities\ReportEntity;
use Exception;
use Illuminate\Support\Str;

class CreateReport
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(array $data): ReportEntity
    {
        try {
            $data['folio'] = $this->generateUniqueFolio();
            return $this->reportRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating report: ' . $e->getMessage());
        }
    }

    private function generateUniqueFolio(): string
    {
        do {
            $folio = Str::upper(Str::random(7));
        } while ($this->reportRepository->getByFolio($folio) !== null);

        return $folio;
    }

    public function getNextId(): int
    {
        return $this->reportRepository->getNextId();
    }
}
