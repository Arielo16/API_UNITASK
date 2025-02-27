<?php

namespace App\Core\Reports\Entities;

class ReportEntity
{
    public $reportID;
    public $folio;
    public $buildingID;
    public $roomName; // Cambiar roomID a roomName
    public $categoryID;
    public $goodID;
    public $priority;
    public $description;
    public $image;
    public $id;
    public $status;
    public $requires_approval;
    public $involve_third_parties;

    public function __construct($reportID, $folio, $buildingID, $roomName, $categoryID, $goodID, $priority, $description, $image, $id, $status, $requires_approval, $involve_third_parties)
    {
        $this->reportID = $reportID;
        $this->folio = $folio;
        $this->buildingID = $buildingID;
        $this->roomName = $roomName; // Cambiar roomID a roomName
        $this->categoryID = $categoryID;
        $this->goodID = $goodID;
        $this->priority = $priority;
        $this->description = $description;
        $this->image = $image;
        $this->id = $id;
        $this->status = $status;
        $this->requires_approval = $requires_approval;
        $this->involve_third_parties = $involve_third_parties;
    }
}
