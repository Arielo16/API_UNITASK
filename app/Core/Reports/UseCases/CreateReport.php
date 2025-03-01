<?php

namespace App\Core\Reports\UseCases;

use App\Core\Reports\Repositories\ReportRepositoryInterface;
use Illuminate\Support\Str;
use Exception;

class CreateReport
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function execute(array $data)
    {
        try {
            $data['folio'] = 'REP' . Str::padLeft($this->reportRepository->getNextId(), 4, '0');
            if (isset($data['file'])) {
                $filePath = $this->uploadFile($data['file']);
                $data['file_path'] = $filePath;
                unset($data['file']);
            }
            return $this->reportRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating report: ' . $e->getMessage());
        }
    }

    private function uploadFile($file)
    {
        // Implement file upload logic here
        return 'path/to/uploaded/file';
    }
}
