<?php

namespace App\Core\Reports\Entities;

class ReportEntity
{
    public $reportID;
    public $folio;
    public $buildingID; // Cambiar buildingName a buildingID
    public $roomID; // Cambiar roomName a roomID
    public $categoryID; // Cambiar categoryName a categoryID
    public $goodName; // Mantener goodName
    public $priority;
    public $description;
    public $image;
    public $id; // Cambiar username a id
    public $status;
    public $requires_approval;
    public $involve_third_parties;

    public function __construct($reportID, $folio, $buildingID, $roomID, $categoryID, $goodName, $priority, $description, $image, $id, $status, $requires_approval, $involve_third_parties)
    {
        $this->reportID = $reportID;
        $this->folio = $folio;
        $this->buildingID = $buildingID; // Cambiar buildingName a buildingID
        $this->roomID = $roomID; // Cambiar roomName a roomID
        $this->categoryID = $categoryID; // Cambiar categoryName a categoryID
        $this->goodName = $goodName; // Mantener goodName
        $this->priority = $priority;
        $this->description = $description;
        $this->image = $image;
        $this->id = $id; // Cambiar username a id
        $this->status = $status;
        $this->requires_approval = $requires_approval;
        $this->involve_third_parties = $involve_third_parties;
    }
}
