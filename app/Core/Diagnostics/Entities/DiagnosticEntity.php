<?php

namespace App\Core\Diagnostics\Entities;

class DiagnosticEntity
{
    public $diagnosticID;
    public $reportID;
    public $description;
    public $images;
    public $status;
    public $created_at;
    public $updated_at;
    public $materials;

    public function __construct($diagnosticID, $reportID, $description, $images, $status, $created_at, $updated_at, $materials = [])
    {
        $this->diagnosticID = $diagnosticID;
        $this->reportID = $reportID;
        $this->description = $description;
        $this->images = $images;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->materials = $materials;
    }
}
